import { useConfirm as PrimeUseConfirm } from 'primevue/useconfirm';

interface iConfirm {
  confirm: (
    message?: string | undefined,
    header?: string | undefined,
  ) => Promise<boolean>;
}

export const useConfirm = (): iConfirm => {
  const confirmDialogue = PrimeUseConfirm();

  const confirm = (
    message: string = 'Are you sure you want to proceed?',
    header: string = 'Confirmation',
  ): Promise<boolean> => {
    return new Promise<boolean>((resolve) => {
      confirmDialogue.require({
        message,
        header,
        rejectProps: {
          label: 'Cancel',
          severity: 'secondary',
          outlined: true,
        },
        acceptProps: {
          label: 'Ok',
        },
        accept: () => resolve(true),
        reject: () => resolve(false),
      });
    });
  };

  return {
    confirm,
  };
};
