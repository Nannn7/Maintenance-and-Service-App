import { getUsers } from '@/services/user';

export default async function UsersPage() {
    const response = await getUsers();

    return (
        <div>
            <h1>Users</h1>

            {response.data.map((user: any) => (
                <div key={user.id}>
                    {user.name}
                </div>
            ))}
        </div>
    );
}