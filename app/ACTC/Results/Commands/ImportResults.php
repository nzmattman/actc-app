<?php

declare(strict_types=1);

namespace ACTC\Results\Commands;

use ACTC\Core\State;
use ACTC\Results\Result;
use ACTC\Results\ResultCategory;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ImportResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports results from Google Sheets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->import();
    }

    private function import()
    {
        $client = $this->getGoogleClient();
        $service = new Sheets($client);
        $documentId = config('services.google.sheets.results');

        $this->info("Fetching spreadsheet: {$documentId}");
        $spreadsheet = $service->spreadsheets->get($documentId);

        $sheets = $spreadsheet->getSheets();
        $this->info('Found '.count($sheets).' sheet(s)');

        // truncate the tables
        Schema::disableForeignKeyConstraints();
        DB::table('results')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($sheets as $sheet) {
            $sheetTitle = $sheet->getProperties()->getTitle();

            $this->info("Processing sheet: {$sheetTitle}");

            $this->processSheet($service, $documentId, $sheetTitle);
        }

        $this->info('Import completed successfully!');

        return 0;
    }

    private function processSheet(Sheets $service, string $documentId, string $sheetTitle): void
    {
        $this->line("  Fetching data from: {$sheetTitle}");

        // Get all data from the sheet
        $range = "{$sheetTitle}!A:Z"; // Adjust range as needed
        $response = $service->spreadsheets_values->get($documentId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            $this->warn("    No data found in sheet: {$sheetTitle}");

            return;
        }

        // First row is typically headers
        $this->line('    Data rows: '.count($values));

        // Process each data row
        $progressBar = $this->output->createProgressBar(count($values));
        $progressBar->start();

        $processed = 0;
        $errors = 0;

        $headers = array_splice($values, 0, 6);

        try {
            $competition = $this->updateOrCreateCompetition($headers);

            if (!$competition) {
                return;
            }

            foreach ($values as $rowIndex => $row) {
                try {
                    // Combine headers with row data
                    if (count($row) < 1) {
                        continue;
                    }

                    $data = [
                        'result_category_id' => $competition->id,
                        'section' => $row[0] ?? null,
                        'division' => $row[1] ?? null,
                        'section_slug' => $row[0] ? Str::slug($row[0]) : 'not-set',
                        'division_slug' => $row[1] ? Str::slug($row[1]) : 'not-set',
                        'item' => $row[2] ?? null,
                        'position' => $row[3] ?? null,
                        'name' => $row[4] ?? null,
                        'points' => $row[5] ?? null,
                    ];

                    Result::create($data);

                    ++$processed;
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->error('    Error processing row '.($rowIndex + 2).': '.$e->getMessage());
                    ++$errors;
                }

                $progressBar->advance();
            }
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('    Error processing row '.$sheetTitle.': '.$e->getMessage());
            ++$errors;
        }

        $progressBar->finish();
        $this->newLine();
        $this->info("    Processed: {$processed} rows, Errors: {$errors}");
        $this->newLine();
    }

    private function updateOrCreateCompetition($headers): ?ResultCategory
    {
        $data = [
            'name' => '',
            'state_id' => 0,
        ];

        $states = State::pluck('id', 'code')->toArray();

        foreach ($headers as $header) {
            if (count($header) < 1) {
                continue;
            }

            if ('Competition Name' === $header[0]) {
                $data['name'] = $header[1];
            }

            if ('Competition Date From' === $header[0] && isset($header[1]) && trim($header[1])) {
                $data['start_at'] = Carbon::createFromFormat('d/m/Y', trim($header[1]));
            }

            if ('Competition Date To' === $header[0] && isset($header[1]) && trim($header[1])) {
                $data['end_at'] = Carbon::createFromFormat('d/m/Y', trim($header[1]));
            }

            if ('State' === $header[0] && isset($header[1])) {
                $data['state_id'] = $states[$header[1]] ?? null;
            }
        }

        if ($data['state_id'] > 1) {
            $category = ResultCategory::updateOrCreate(
                [
                    'name' => $data['name'],
                    'state_id' => $data['state_id'],
                ],
                $data
            );

            $category->touch();

            return $category;
        }

        return null;
    }

    private function getGoogleClient(): Client
    {
        $client = new Client();

        // Set credentials
        $credentialsPath = config('services.google.credentials');
        if (!file_exists($credentialsPath)) {
            throw new \Exception("Credentials file not found at: {$credentialsPath}");
        }

        $client->setAuthConfig($credentialsPath);
        $client->addScope(Sheets::SPREADSHEETS_READONLY);
        $client->setApplicationName('ACTC Google Sheets Importer');

        return $client;
    }
}
