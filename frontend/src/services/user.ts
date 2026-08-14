import { apiFetch } from './api';

export async function getUsers() {
    const response = await apiFetch('/api/users');

    if (!response.ok) {
        throw new Error('Failed to fetch users');
    }

    return response.json();
}