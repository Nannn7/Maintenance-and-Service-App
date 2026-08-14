const API_URL = process.env.NEXT_PUBLIC_API_URL;

export async function apiFetch(
    endpoint: string,
    options: RequestInit = {}
) {
    const response = await fetch(
        `${API_URL}${endpoint}`,
        {
            ...options,
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...options.headers,
            },
        }
    );

    return response;
}