import React from "react";
import { usePage, useForm } from "@inertiajs/react";

const Dashboard = () => {
    const { auth } = usePage().props;
    const permissions = auth.user.permissions; // array of permission names

    const { post } = useForm(); // For logout

    // Helper function
    const can = (permission) => permissions.includes(permission);

    return (
        <div className="max-w-3xl mx-auto py-8 flex flex-col gap-6">
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">Dashboard</h1>
                <button
                    onClick={() => post("/logout")}
                    className="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                >
                    Logout
                </button>
            </div>

            {can("view products") && (
                <div className="bg-white shadow p-6 rounded">
                    <h2 className="font-semibold text-lg mb-2">Inventory</h2>
                    <p className="text-gray-600 mb-4">
                        View and manage product stock.
                    </p>
                    <button className="text-blue-500 hover:underline">
                        Go to Products
                    </button>
                </div>
            )}

            {can("manage categories") && (
                <div className="bg-white shadow p-6 rounded">
                    <h2 className="font-semibold text-lg mb-2">Categories</h2>
                    <p className="text-gray-600 mb-4">
                        Manage product categories.
                    </p>
                    <button className="text-teal-600 hover:underline">
                        Go to Categories
                    </button>
                </div>
            )}

            {can("create sales") && (
                <div className="bg-white shadow p-6 rounded">
                    <h2 className="font-semibold text-lg mb-2">Sales</h2>
                    <p className="text-gray-600 mb-4">
                        Record and view sales transactions.
                    </p>
                    <button className="text-green-500 hover:underline">
                        Go to Sales
                    </button>
                </div>
            )}

            {can("create purchases") && (
                <div className="bg-white shadow p-6 rounded">
                    <h2 className="font-semibold text-lg mb-2">Purchases</h2>
                    <p className="text-gray-600 mb-4">
                        Add inventory purchases.
                    </p>
                    <button className="text-indigo-500 hover:underline">
                        Go to Purchases
                    </button>
                </div>
            )}

            {can("view analytics") && (
                <div className="bg-white shadow p-6 rounded">
                    <h2 className="font-semibold text-lg mb-2">Analytics</h2>
                    <p className="text-gray-600 mb-4">
                        View sales reports and trends.
                    </p>
                    <button className="text-yellow-600 hover:underline">
                        View Analytics
                    </button>
                </div>
            )}

            {can("view profit reports") && (
                <div className="bg-white shadow p-6 rounded">
                    <h2 className="font-semibold text-lg mb-2">
                        Profit Reports
                    </h2>
                    <p className="text-gray-600 mb-4">
                        Check shop profit performance.
                    </p>
                    <button className="text-purple-600 hover:underline">
                        View Profit
                    </button>
                </div>
            )}

            {can("manage users") && (
                <div className="bg-white shadow p-6 rounded">
                    <h2 className="font-semibold text-lg mb-2">
                        User Management
                    </h2>
                    <p className="text-gray-600 mb-4">
                        Create and manage users and roles.
                    </p>
                    <a href="/users" className="text-red-600 hover:underline">
                        Manage Users
                    </a>
                </div>
            )}
        </div>
    );
};

export default Dashboard;
