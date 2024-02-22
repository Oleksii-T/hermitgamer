import Swal from 'sweetalert2';

export default {
    showLoading(text='Request processing...') {
        return Swal.fire({
            title: 'Wait!',
            text: text,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    },
    showError(title='Oops!', text='Something goes wrong<br>Please refresh the page and try again') {
        return Swal.fire(title, text, 'error');
    },
    showNotif(title='', text='', type=true) {
        if (typeof type == 'boolean') {
            type = type ? 'success' : 'error';
        }
        return Swal.fire(title, text, type);
    },
    objToFormData(formData, data, parentKey) {
        if (Array.isArray(data)) {
            for (let i = 0; i < data.length; i++) {
                this.objToFormData(formData, data[i], parentKey ? `${parentKey}[${i}]` : parentKey);
            }
        } else if (data && typeof data === "object" && !(data instanceof File)) {
            Object.keys(data).forEach((key) => {
                this.objToFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key)
            })
        } else {
            if (!data) {
                return
            }

            let value = typeof data === "boolean" || typeof data === "number" ? data.toString() : data
            formData.append(parentKey, value)
        }
    }
};
