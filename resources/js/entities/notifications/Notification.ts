export interface Notification {
  id: string;
  date: string;
  created: string;
  read: boolean;
  heading?: string;
  message?: string;
  isMarkingAsRead?: boolean;
  isDeleting?: boolean;
}
