import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { login } from "../../api/authService";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const navigate = useNavigate();

    const handleLogin = async (e) => {
        e.preventDefault();
        try {
            const data = await login(email, password);

            localStorage.setItem("token", data.token);
            localStorage.setItem("userRole", data.user.role);

            if (data.user.role === "student") {
                navigate("/student-dashboard");
            } else if (data.user.role === "instructor") {
                navigate("/instructor-dashboard");
            } else if (data.user.role === "admin") {
                navigate("/admin-dashboard");
            } else {
                setError("Invalid user role");
            }
        } catch (err) {
            setError(err.response?.data?.error || "An error occurred");
        }
    };

    return (
        <div>
            <h1>Login</h1>
            <form onSubmit={handleLogin}>
                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                />
                <input
                    type="password"
                    placeholder="Password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                />
                <button type="submit">Login</button>
                {error && <p style={{ color: "red" }}>{error}</p>}
            </form>
        </div>
    );
};

export default Login;
