export type User = {
    public_id: string;
    username: string;
    email: string;
    profile_photo_path?: string;
    user_desc: string,
    full_name: string,
    role: string,
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
