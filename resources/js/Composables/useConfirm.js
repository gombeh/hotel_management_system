import {router} from '@inertiajs/vue3'
import Swal from "sweetalert2";

export function useConfirm() {
    return (url, options = {}) => {
        Swal.fire({
            title: options.title || 'Are you sure?',
            text: options.text || "This action cannot be undone!",
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: options.confirmButtonColor || '#d33',
            cancelButtonColor: options.cancelButtonColor || '#3085d6',
            confirmButtonText: options.confirmButtonText || 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(url)
            }
        })
    }
}
