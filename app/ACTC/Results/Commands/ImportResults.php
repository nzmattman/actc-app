<?php

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
        DB::table('result_categories')->truncate();
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

        $competition = $this->createCompetition($headers);

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
                    'item' => $row[2] ?? null,
                    'position' => $row[3] ?? null,
                    'name' => $row[4] ?? null,
                    'points' => $row[5] ?? null,
                ];

                Result::create($data);

                $processed++;
            } catch (\Exception $e) {
                $this->newLine();
                $this->error('    Error processing row '.($rowIndex + 2).': '.$e->getMessage());
                $errors++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info("    Processed: {$processed} rows, Errors: {$errors}");
    }

    private function createCompetition($headers)
    {
        $data = [
            'name' => '',
            'start_at' => '',
            'end_at' => '',
            'state_id' => 0,
        ];

        $states = State::pluck('id', 'code')->toArray();

        foreach ($headers as $header) {
            if (count($header) < 1) {
                continue;
            }

            if ($header[0] === 'Competition Name') {
                $data['name'] = $header[1];
            }

            if ($header[0] === 'Competition Date From') {
                $data['start_at'] = Carbon::parse($header[1]);
            }

            if ($header[0] === 'Competition Date To') {
                $data['end_at'] = Carbon::parse($header[1]);
            }

            if ($header[0] === 'State') {
                $data['state_id'] = $states[$header[1]] ?? null;
            }
        }

        return ResultCategory::create($data);
    }

    private function getGoogleClient(): Client
    {
        $client = new Client;

        // Set credentials
        $credentialsPath = config('services.google.credentials');
        if (! file_exists($credentialsPath)) {
            throw new \Exception("Credentials file not found at: {$credentialsPath}");
        }

        $client->setAuthConfig($credentialsPath);
        $client->addScope(Sheets::SPREADSHEETS_READONLY);
        $client->setApplicationName('ACTC Google Sheets Importer');

        return $client;
    }
}
