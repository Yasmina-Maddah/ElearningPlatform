import api from "./api"; 

export const login = async (email, password) => {
    const response = await api.post("/auth/login.php", { email, password });
    return response.data; 
    
};

export const register = async (userData) => {
    const response = await api.post("/auth/register.php", userData);
    return response.data; 
};
