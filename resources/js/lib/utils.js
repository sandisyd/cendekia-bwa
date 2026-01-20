import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

export const FINEPAYMENTSTATUS = {
    PENDING: 'Tertunda',
    SUCCESS: 'Berhasil',
    FAILED: 'Gagal',
};

export function flashMessage(params) {
    return params.props.flash_message;
}

export const formatMoney = (amount) => {
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    });
    return formatter.format(amount);
};

export const messages = {
    503: {
        title: 'Service Unavailable',
        description: "Sorry, we're doing some maintenance. Please comeback soon.",
        status: '503',
    },
    500: {
        title: 'Server Error',
        description: 'Oops, something when wrong on our servers.',
        status: '500',
    },
    404: {
        title: 'Not Found',
        description: 'Sorry, page not found.',
        status: '404',
    },
    403: {
        title: 'Forbidden',
        description: "Sorry, you're no access for this page.",
        status: '403',
    },
    401: {
        title: 'Unauthorized',
        description: "Sorry, you're unauthorized to access",
        status: '401',
    },
    429: {
        title: 'Too Many Reqeust',
        description: 'Please try again later.',
        status: '429',
    },
};
