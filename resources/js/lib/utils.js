import { clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs) {
  return twMerge(clsx(inputs));
}

export const FINEPAYMENTSTATUS = {
  PENDING: "Tertunda",
  SUCCESS: "Berhasil",
  FAILED: "Gagal",
};

export function flashMessage(params) {
  return params.props.flash_message;
}

export const formatMoney = (amount) => {
  const formatter = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });
  return formatter.format(amount);
};
