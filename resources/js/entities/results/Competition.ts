export interface CompetitionDivision {
  name: string;
  slug: string;
}

export interface CompetitionSection {
  name: string;
  slug: string;
  divisions: CompetitionDivision[];
}

export interface CompetitionItem {
  id: string;
  name: string;
  dates: string;
  sections: CompetitionSection[];
}
