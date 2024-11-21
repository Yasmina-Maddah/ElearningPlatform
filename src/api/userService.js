import api from "./api";

export const getUsers = async () => {
    const response = await api.get("/users/getUsers.php");
    return response.data;
};

export const createUser = async (userData) => {
    const response = await api.post("/users/createUser.php", userData);
    return response.data;
};

export const deleteUser = async (userId) => {
    const response = await api.delete("/users/deleteUser.php", {
        data: { userId },
    });
    return response.data;
};

export const banUser = async (userId) => {
    const response = await api.put("/users/banUser.php", { userId });
    return response.data;
};