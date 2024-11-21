import api from "./api"; 

export const getPlatformStats = async () => {
    const response = await api.get("/admin/getPlatformStats.php");
    return response.data;
};

export const getAllUsers = async () => {
    const response = await api.get("/admin/getAllUsers.php");
    return response.data;
};

export const createUser = async (userData) => {
    const response = await api.post("/admin/createUser.php", userData);
    return response.data;
};

export const deleteUser = async (userId) => {
    const response = await api.delete("/admin/deleteUser.php", {
        data: { userId },
    });
    return response.data;
};


export const banUser = async (userId) => {
    const response = await api.put("/admin/banUser.php", { userId });
    return response.data;
};
