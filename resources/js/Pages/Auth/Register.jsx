import ApplicationLogo from '@/Components/ApplicationLogo';
import InputError from '@/Components/InputError';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import GuestLayout from '@/Layouts/GuestLayout';
import { Link, useForm } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const onHandleChange = (e) => setData(e.target.name, e.target.value);

    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <div className="w-full lg:grid lg:min-h-screen lg:grid-cols-2">
            <div className="flex flex-col px-6 py-4">
                <ApplicationLogo size="size-12" />
                <div className="flex flex-col items-center justify-center py-12 lg:py-48">
                    <div className="mx-auto flex w-full flex-col gap-6 lg:w-1/2">
                        <div className="grid gap-2 text-center">
                            <h1 className="text-3xl font-bold">Register</h1>
                            <p className="text-balance text-muted-foreground">
                                Silahkan isi data dibawah ini untuk membuat akun
                            </p>
                        </div>
                        <form onSubmit={submit}>
                            <div className="grid gap-4">
                                <div className="grid gap-2">
                                    <Label htmlFor="name">Nama</Label>

                                    <Input
                                        id="name"
                                        name="name"
                                        value={data.name}
                                        autoComplete="name"
                                        onChange={onHandleChange}
                                    />

                                    {errors.name && <InputError message={errors.name} className="mt-2" />}
                                </div>
                                <div className="grid gap-2">
                                    <Label htmlFor="email">Email</Label>

                                    <Input
                                        id="email"
                                        name="email"
                                        value={data.email}
                                        autoComplete="username"
                                        type="email"
                                        onChange={onHandleChange}
                                    />

                                    {errors.email && <InputError message={errors.email} className="mt-2" />}
                                </div>
                                <div className="grid gap-2">
                                    <Label htmlFor="password">Password</Label>

                                    <Input
                                        id="password"
                                        name="password"
                                        value={data.password}
                                        autoComplete="new-password"
                                        type="password"
                                        onChange={onHandleChange}
                                    />

                                    {errors.password && <InputError message={errors.password} className="mt-2" />}
                                </div>
                                <div className="grid gap-2">
                                    <Label htmlFor="password_confirmation">Confirm Password</Label>

                                    <Input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        value={data.password_confirmation}
                                        autoComplete="new-password"
                                        type="password"
                                        onChange={onHandleChange}
                                    />

                                    {errors.password_confirmation && (
                                        <InputError message={errors.password_confirmation} className="mt-2" />
                                    )}
                                </div>
                                <Button
                                    className="w-full"
                                    size="xl"
                                    type="submit"
                                    variant="orange"
                                    disabled={processing}
                                >
                                    Register
                                </Button>
                            </div>
                            <div className="mt-4 text-center text-sm">
                                Sudah punya akun? <Link href={route('login')}>Login</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div className="hidden bg-muted lg:block">
                <img
                    src="/images/login.webp"
                    alt="Login"
                    className="h-full w-full object-cover dark:brightness-[0.4] dark:grayscale"
                />
            </div>
        </div>
    );
}

Register.layout = (page) => <GuestLayout children={page} title="Register" />;
