export default function Welcome({ auth }) {
    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex flex-col items-center justify-center p-4">
            {/* Decorative elements */}
            <div className="absolute inset-0 overflow-hidden pointer-events-none">
                <div className="absolute -top-40 -right-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
                <div className="absolute -bottom-40 -left-40 w-80 h-80 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            </div>

            {/* Main content */}
            <div className="relative z-10 max-w-2xl w-full text-center">
                {/* Logo/Brand Icon */}
                <div className="mb-8 flex justify-center">
                    <div className="bg-gradient-to-r from-blue-600 to-purple-600 p-4 rounded-2xl shadow-lg">
                        <svg
                            className="w-12 h-12 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                            />
                        </svg>
                    </div>
                </div>

                {/* Title with gradient */}
                <h1 className="text-5xl md:text-6xl font-extrabold mb-6 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Small Shop Inventory System
                </h1>

                {/* Description */}
                <p className="text-lg md:text-xl text-gray-600 mb-8 max-w-md mx-auto">
                    Manage your stock, sales, and forecasting with ease and
                    precision.
                </p>

                {/* Feature badges */}
                <div className="flex flex-wrap justify-center gap-3 mb-12">
                    <span className="px-3 py-1 bg-white/80 backdrop-blur-sm rounded-full text-sm text-gray-600 shadow-sm">
                        📦 Stock Management
                    </span>
                    <span className="px-3 py-1 bg-white/80 backdrop-blur-sm rounded-full text-sm text-gray-600 shadow-sm">
                        💰 Sales Tracking
                    </span>
                    <span className="px-3 py-1 bg-white/80 backdrop-blur-sm rounded-full text-sm text-gray-600 shadow-sm">
                        📊 Analytics
                    </span>
                    <span className="px-3 py-1 bg-white/80 backdrop-blur-sm rounded-full text-sm text-gray-600 shadow-sm">
                        🔮 Forecasting
                    </span>
                </div>

                {/* Buttons */}
                <div className="flex gap-4 justify-center">
                    {auth.user ? (
                        <a
                            href="/dashboard"
                            className="group relative px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                        >
                            <span className="relative z-10">
                                Go to Dashboard
                            </span>
                            <div className="absolute inset-0 bg-gradient-to-r from-blue-700 to-blue-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        </a>
                    ) : (
                        <>
                            <a
                                href="/login"
                                className="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                            >
                                Login
                            </a>
                            <a
                                href="/register"
                                className="px-8 py-3 bg-gradient-to-r from-gray-800 to-gray-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                            >
                                Register
                            </a>
                        </>
                    )}
                </div>

                {/* Footer text */}
                <p className="mt-12 text-sm text-gray-500">
                    Start managing your inventory smarter today
                </p>
            </div>

            {/* Add custom animations */}
            <style jsx>{`
                @keyframes blob {
                    0% {
                        transform: translate(0px, 0px) scale(1);
                    }
                    33% {
                        transform: translate(30px, -50px) scale(1.1);
                    }
                    66% {
                        transform: translate(-20px, 20px) scale(0.9);
                    }
                    100% {
                        transform: translate(0px, 0px) scale(1);
                    }
                }
                .animate-blob {
                    animation: blob 7s infinite;
                }
                .animation-delay-2000 {
                    animation-delay: 2s;
                }
                .animation-delay-4000 {
                    animation-delay: 4s;
                }
            `}</style>
        </div>
    );
}
