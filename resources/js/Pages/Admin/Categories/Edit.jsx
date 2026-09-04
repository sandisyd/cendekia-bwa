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

export default function Edit(props) {
  const { data, setData, reset, post, processing, errors } = useForm({
    name: props.category.name ?? "",
    description: props.category.description ?? "",
    cover: null,
    _method: props.page_settings.methods,
  });

  const onHandleChange = (e) => setData(e.target.name, e.target.value);

  const onHandleSubmit = (e) => {
    e.preventDefault();
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
              <Label htmlFor="name">Judul</Label>
              <Input
                name="name"
                id="name"
                type="text"
                placeholder="Masukkan Judul..."
                value={data.name}
                onChange={onHandleChange}
              />

              {errors.name && (
                <InputError message={errors.name} className="mt-2" />
              )}
            </div>
            <div className="grid w-full items-center gap-1.5">
              <Label htmlFor="description">Deskripsi</Label>
              <Textarea
                name="description"
                id="description"
                type="text"
                placeholder="Masukkan Deskripsi..."
                value={data.description}
                onChange={onHandleChange}
              ></Textarea>
              {errors.description && (
                <InputError message={errors.description} className="mt-2" />
              )}
            </div>
            <div className="grid w-full items-center gap-1.5">
              <Label htmlFor="cover">Cover</Label>
              <Input
                name="cover"
                id="cover"
                type="file"
                onChange={(e) => setData(e.target.name, e.target.files[0])}
                ref={inputFileRef}
              />
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

Edit.layout = (page) => (
  <AppLayout children={page} title={page.props.page_settings.title} />
);
