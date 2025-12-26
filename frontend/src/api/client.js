import axios from 'axios';

// API Base URL - use environment variable or default to localhost:8000
const API_BASE = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

console.log('API Base URL:', API_BASE);
console.log('Environment:', import.meta.env.MODE);

// Create axios instance with default config
const api = axios.create({
  baseURL: API_BASE,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  timeout: 30000, // 30 second timeout
});

// Request interceptor to add auth token
api.interceptors.request.use(
  (config) => {
    const token = window.localStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Response interceptor for error handling - convert to human-readable messages
api.interceptors.response.use(
  (response) => response,
  (error) => {
    let message = 'Something went wrong. Please try again.';
    
    if (error.response) {
      // Server responded with error
      const data = error.response.data;
      
      // Use the message from the API if available
      if (data?.message) {
        message = data.message;
      } else if (data?.errors) {
        // Handle validation errors
        const firstError = Object.values(data.errors)[0];
        message = Array.isArray(firstError) ? firstError[0] : firstError;
      } else {
        // Map HTTP status codes to friendly messages
        const statusMessages = {
          400: 'Your request was invalid. Please check your input and try again.',
          401: 'Please log in to continue.',
          403: 'You do not have permission to perform this action.',
          404: 'The requested resource was not found.',
          405: 'This action is not allowed.',
          422: 'Please check your input and try again.',
          429: 'Too many requests. Please wait a moment and try again.',
          500: 'Something went wrong on our end. Please try again later.',
          503: 'The service is temporarily unavailable. Please try again later.',
        };
        message = statusMessages[error.response.status] || message;
      }
    } else if (error.request) {
      // Request was made but no response received
      message = 'Unable to connect to the server. Please check your internet connection and try again.';
    } else {
      // Something else happened
      message = error.message || message;
    }
    
    return Promise.reject(new Error(message));
  }
);

// GET request
export async function apiGet(path, params = {}) {
  const response = await api.get(path, { params });
  return response.data;
}

// POST request
export async function apiPost(path, data = {}) {
  const response = await api.post(path, data);
  return response.data;
}

// PUT request
export async function apiPut(path, data = {}) {
  const response = await api.put(path, data);
  return response.data;
}

// PATCH request
export async function apiPatch(path, data = {}) {
  const response = await api.patch(path, data);
  return response.data;
}

// DELETE request
export async function apiDelete(path) {
  try {
  const response = await api.delete(path);
  return response.status === 204 ? null : response.data;
  } catch (error) {
    // If 404, the resource was already deleted - treat as success
    if (error.response?.status === 404) {
      return null;
    }
    throw error;
  }
}

// Export the axios instance for direct usage if needed
export default api;
