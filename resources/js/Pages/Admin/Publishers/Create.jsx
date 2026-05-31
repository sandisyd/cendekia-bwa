import HeaderTitle from "@/Components/HeaderTitle";
import InputError from "@/Components/InputError";
import { Button } from "@/Components/ui/button";
import { Card, CardContent } from "@/Components/ui/card";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import AppLayout from "@/Layouts/AppLayout";
import { flashMessage } from "@/lib/utils";
import { Link, useForm } from "@inertiajs/react";
import { IconArrowBack, IconCategory } from "@tabler/icons-react";
import { useRef } from "react";
import { toast } from "sonner";

export default function Create(props) {
  const { data, setData, reset, post, processing, errors } = useForm({
    name: "",
    address: "",
    email: "",
    phone: "",
    _method: props.page_settings.methods,
  });

  const onHandleChange = (e) => setData(e.target.name, e.target.value);

  const onHandleSubmit = (e) => {
    e.preventDefault();
    console.log(data);
    post(props.page_settings.action, {
      preserveScroll: true,
      preserveState: true,
      onSuccess: (s) => {
        const flash = flashMessage(s);
        if (flash) toast[flash.type](flash.message);
      },
    });
  };

  const inputFileRef = useRef(null);

  const onHandleReset = () => {
    reset();
    inputFileRef.current.value = null;
  };
  return (
    <div className="flex w-full flex-col pb-32">
      <div className="mb-8 flex flex-col items-start justify-between gap-y-4 lg:flex-row lg:items-center">
        <HeaderTitle
          title={props.page_settings.title}
          subtitle={props.page_settings.subtitle}
          icon={IconCategory}
        />
        <Button variant="orange" size="lg" asChild>
          <Link href={route("admin.categories.index")}>
            <IconArrowBack className="size-4" /> Kembali
          </Link>
        </Button>
      </div>
      <Card>
        <CardContent className="p-6">
          <form className="space-y-6" onSubmit={onHandleSubmit}>
            <div className="grid w-full items-center gap-1.5">
              <Label htmlFor="name">Nama Penerbit</Label>
              <Input
                name="name"
                id="name"
                type="text"
                placeholder="Masukkan Nama Penerbit..."
                value={data.name}
                onChange={onHandleChange}
              />

              {errors.name && (
                <InputError message={errors.name} className="mt-2" />
              )}
            </div>
            <div className="grid w-full items-center gap-1.5">
              <Label htmlFor="address">Alamat</Label>
              <Textarea
                name="address"
                id="address"
                type="text"
                placeholder="Masukkan Alamat..."
                value={data.address}
                onChange={onHandleChange}
              ></Textarea>
              {errors.address && (
                <InputError message={errors.address} className="mt-2" />
              )}
            </div>
            <div className="grid w-full items-center gap-1.5">
              <Label htmlFor="email">Email</Label>
              <Textarea
                name="email"
                id="email"
                type="text"
                placeholder="Masukkan Email..."
                value={data.email}
                onChange={onHandleChange}
              ></Textarea>
              {errors.email && (
                <InputError message={errors.email} className="mt-2" />
              )}
            </div>
            <div className="grid w-full items-center gap-1.5">
              <Label htmlFor="phone">Nomor Handphone</Label>
              <Textarea
                name="phone"
                id="phone"
                type="text"
                placeholder="Masukkan Nomor HP..."
                value={data.phone}
                onChange={onHandleChange}
              ></Textarea>
              {errors.phone && (
                <InputError message={errors.phone} className="mt-2" />
              )}
            </div>

            <div className="flex justify-end gap-x-2">
              <Button
                type="button"
                variant="ghost"
                size="lg"
                onClick={onHandleReset}
              >
                Reset
              </Button>
              <Button
                type="submit"
                variant="orange"
                size="lg"
                disabled={processing}
              >
                Save
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  );
}

Create.layout = (page) => (
  <AppLayout children={page} title={page.props.page_settings.title} />
);
