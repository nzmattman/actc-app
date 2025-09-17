export interface ResultsListItem {
  id: string;
  state: string;
  name: string;
  route: string;
  slug: {
    state: string;
    competition: string;
    section: string;
    division: string;
  };
  date: string;
}
