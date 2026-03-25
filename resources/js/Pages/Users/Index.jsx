import React, { useState } from "react";
import { usePage, useForm } from "@inertiajs/react";

export default function UsersIndex() {
    const { users: initialUsers, roles } = usePage().props;
    const [editingUser, setEditingUser] = useState(null); // null = creating new
    const [modalOpen, setModalOpen] = useState(false);

    const {
        data,
        setData,
        post,
        put,
        delete: destroy,
        reset,
        processing,
        errors,
    } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        role: roles[0]?.name || "",
    });

    // Open modal for create
    const openCreate = () => {
        reset();
        setEditingUser(null);
        setModalOpen(true);
    };

    // Open modal for edit
    const openEdit = (user) => {
        setEditingUser(user);
        setData({
            name: user.name,
            email: user.email,
            password: "",
            password_confirmation: "",
            role: user.roles[0]?.name || "",
        });
        setModalOpen(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (editingUser) {
            put(`/users/${editingUser.id}`, {
                onSuccess: () => setModalOpen(false),
            });
        } else {
            post("/users", {
                onSuccess: () => setModalOpen(false),
            });
        }
    };

    const handleDelete = (user) => {
        if (!confirm(`Are you sure you want to delete ${user.name}?`)) return;
        destroy(`/users/${user.id}`);
    };

    return (
        <div className="max-w-5xl mx-auto py-8">
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">Manage Users</h1>
                <button
                    onClick={openCreate}
                    className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Add User
                </button>
            </div>

            <table className="w-full border-collapse border border-gray-300">
                <thead>
                    <tr className="bg-gray-100">
                        <th className="border px-4 py-2">Name</th>
                        <th className="border px-4 py-2">Email</th>
                        <th className="border px-4 py-2">Role</th>
                        <th className="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {initialUsers.map((user) => (
                        <tr key={user.id}>
                            <td className="border px-4 py-2">{user.name}</td>
                            <td className="border px-4 py-2">{user.email}</td>
                            <td className="border px-4 py-2">
                                {user.roles.map((r) => r.name).join(", ")}
                            </td>
                            <td className="border px-4 py-2 flex gap-2">
                                <button
                                    onClick={() => openEdit(user)}
                                    className="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                >
                                    Edit
                                </button>
                                <button
                                    onClick={() => handleDelete(user)}
                                    className="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>

            {/* Modal */}
            {modalOpen && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div className="bg-white p-6 rounded-lg w-96 relative">
                        <h2 className="text-xl font-bold mb-4">
                            {editingUser ? "Edit User" : "Create User"}
                        </h2>

                        <form
                            onSubmit={handleSubmit}
                            className="flex flex-col gap-3"
                        >
                            <input
                                type="text"
                                placeholder="Name"
                                value={data.name}
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                                className="border p-2 rounded"
                            />
                            {errors.name && (
                                <p className="text-red-500">{errors.name}</p>
                            )}

                            <input
                                type="email"
                                placeholder="Email"
                                value={data.email}
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                                className="border p-2 rounded"
                            />
                            {errors.email && (
                                <p className="text-red-500">{errors.email}</p>
                            )}

                            <input
                                type="password"
                                placeholder="Password"
                                value={data.password}
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                                className="border p-2 rounded"
                            />
                            {errors.password && (
                                <p className="text-red-500">
                                    {errors.password}
                                </p>
                            )}

                            <input
                                type="password"
                                placeholder="Confirm Password"
                                value={data.password_confirmation}
                                onChange={(e) =>
                                    setData(
                                        "password_confirmation",
                                        e.target.value,
                                    )
                                }
                                className="border p-2 rounded"
                            />

                            <select
                                value={data.role}
                                onChange={(e) =>
                                    setData("role", e.target.value)
                                }
                                className="border p-2 rounded"
                            >
                                {roles.map((role) => (
                                    <option key={role.id} value={role.name}>
                                        {role.name}
                                    </option>
                                ))}
                            </select>

                            <div className="flex justify-end gap-2 mt-4">
                                <button
                                    type="button"
                                    onClick={() => setModalOpen(false)}
                                    className="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                                >
                                    {editingUser ? "Update" : "Create"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
}
