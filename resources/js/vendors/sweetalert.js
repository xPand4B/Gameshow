import i18n from './../src/snippets/index';
/** https://sweetalert2.github.io/ */
import Swal from 'sweetalert2';

window.Swal = Swal.mixin({
    confirmButtonColor: i18n.t('general.modal.confirmColor'),
    cancelButtonText: i18n.t('general.cancel'),
    cancelButtonColor: i18n.t('general.modal.cancelColor'),
});

window.Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 8000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
