export interface ClubStateListItem {
  id: string;
  name: string;
  count: number;
  route: string;
  slug: string;
  state: string;
  isLoading?: boolean;
}
