import { ToastLocationGroup, ToastSeverity } from '@/entities';
import { useToast as PrimeUseToast } from 'primevue/usetoast';

interface iToast {
  pop: (
    summary: string,
    detail: string,
    severity?: ToastSeverity,
    life?: number,
    group?: ToastLocationGroup,
  ) => void;

  popError: (summary: string, detail: string) => void;
}

export const useToast = (): iToast => {
  const burntToast = PrimeUseToast();

  const pop = (
    summary: string,
    detail: string,
    severity: ToastSeverity = ToastSeverity.INFO,
    life: number = 5000,
    group: ToastLocationGroup = ToastLocationGroup.BOTTOM_RIGHT,
  ) => {
    burntToast.add({
      severity,
      summary,
      detail,
      life,
      group,
    });
  };

  const popError = (summary: string, detail: string) => {
    pop(summary, detail, ToastSeverity.ERROR);
  };

  return {
    pop,
    popError,
  };
};
