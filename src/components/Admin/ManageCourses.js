import React, { useEffect, useState } from "react";
import { getUsers, createUser, deleteUser, banUser } from "../../api/userService";

const ManageUsers = () => {
    const [users, setUsers] = useState([]);
    const [newUser, setNewUser] = useState({ name: "", email: "", role: "student" });
    const [message, setMessage] = useState("");

    useEffect(() => {
        const fetchUsers = async () => {
            try {
                const data = await getUsers();
                setUsers(data.users);
            } catch (error) {
                console.error("Error fetching users:", error);
            }
        };

        fetchUsers();
    }, []);

    const handleCreateUser = async () => {
        try {
            const data = await createUser(newUser);
            setMessage(data.message);
            setUsers([...users, data.user]);
        } catch (error) {
            setMessage("Error creating user.");
        }
    };

    const handleDeleteUser = async (userId) => {
        try {
            const data = await deleteUser(userId);
            setMessage(data.message);
            setUsers(users.filter((user) => user.id !== userId));
        } catch (error) {
            setMessage("Error deleting user.");
        }
    };

    const handleBanUser = async (userId) => {
        try {
            const data = await banUser(userId);
            setMessage(data.message);
        } catch (error) {
            setMessage("Error banning user.");
        }
    };

    return (
        <div>
            <h1>Manage Users</h1>
            <div>
                <h2>Create New User</h2>
                <input
                    type="text"
                    placeholder="Name"
                    value={newUser.name}
                    onChange={(e) => setNewUser({ ...newUser, name: e.target.value })}
                />
                <input
                    type="email"
                    placeholder="Email"
                    value={newUser.email}
                    onChange={(e) => setNewUser({ ...newUser, email: e.target.value })}
                />
                <select
                    value={newUser.role}
                    onChange={(e) => setNewUser({ ...newUser, role: e.target.value })}
                >
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                </select>
                <button onClick={handleCreateUser}>Create</button>
            </div>
            <h2>All Users</h2>
            <ul>
                {users.map((user) => (
                    <li key={user.id}>
                        {user.name} - {user.role}
                        <button onClick={() => handleDeleteUser(user.id)}>Delete</button>
                        <button onClick={() => handleBanUser(user.id)}>Ban</button>
                    </li>
                ))}
            </ul>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ManageUsers;