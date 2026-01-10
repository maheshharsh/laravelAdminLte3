import { ReactNode, useEffect, useState } from "react";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import Advertisement from "../components/Advertisment";
import axios from "axios";

interface MainLayoutProps {
    children: ReactNode;
    currentRoute: string;
}

interface AdvertisementData {
    id: number;
    title: string;
    adv_image: string | null;
}

export default function AppLayout({ children, currentRoute }: MainLayoutProps) {
    const [advertisements, setAdvertisements] = useState<AdvertisementData[]>(
        []
    );

    useEffect(() => {
        const fetchAdvertisements = async () => {
            try {
                const response = await axios.get("/advertisements");
                setAdvertisements(response.data.data);
            } catch (error) {
                console.error("Error fetching advertisements:", error);
            }
        };

        fetchAdvertisements();
    }, []);

    // Split advertisements into two halves for left and right sidebars
    const midPoint = Math.ceil(advertisements.length / 2);
    const leftAds = advertisements.slice(0, midPoint);
    const rightAds = advertisements.slice(midPoint);

    return (
        <div className="flex flex-col min-h-screen bg-gray-50" style={{ paddingTop: '7rem' }}>
            {/* Navbar */}
            <Navbar currentRoute={currentRoute} />

            {/* Main Content Area */}
            <div className="flex flex-col lg:flex-row flex-1 overflow-hidden pt-2">
                {/* Mobile-only Advertisements - Vertical stack on mobile */}
                <div className="block lg:hidden w-full mb-4">
                    {advertisements.length > 0 ? (
                        <div className="space-y-6 px-4">
                            {advertisements.map((ad) => (
                                <div key={ad.id} className="w-full">
                                    <Advertisement
                                        adv_image={ad.adv_image ?? undefined}
                                        title={ad.title}
                                        className="mb-0"
                                    />
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="px-4">
                            <Advertisement
                                adv_image={undefined}
                                title="Placeholder Ad"
                                className="w-full"
                            />
                        </div>
                    )}
                </div>

                {/* Left Advertisements - Hidden on mobile, scrollable on desktop */}
                <div className="hidden lg:block lg:w-1/6 overflow-y-auto">
                    <div className="p-1 space-y-2 sticky top-4">
                        {leftAds.map((ad) => (
                            <Advertisement
                                key={ad.id}
                                adv_image={ad.adv_image ?? undefined}
                                title={ad.title}
                                className="mb-0"
                            />
                        ))}
                        {leftAds.length === 0 && (
                            <Advertisement
                                adv_image={undefined}
                                title="Ad Space Available"
                            />
                        )}
                    </div>
                </div>

                {/* Main Content - Full width on mobile, centered on desktop */}
                <main className="w-full lg:w-4/6 overflow-y-auto px-1 lg:px-3 pb-8 pt-2">
                    {children}
                </main>

                {/* Right Advertisements - Hidden on mobile, scrollable on desktop */}
                <div className="hidden lg:block lg:w-1/6 overflow-y-auto">
                    <div className="p-1 space-y-2 sticky top-4">
                        {rightAds.map((ad) => (
                            <Advertisement
                                key={ad.id}
                                adv_image={ad.adv_image ?? undefined}
                                title={ad.title}
                                className="mb-0"
                            />
                        ))}
                        {rightAds.length === 0 && (
                            <Advertisement
                                adv_image={undefined}
                                title="Ad Space Available"
                            />
                        )}
                    </div>
                </div>
            </div>

            {/* Footer */}
            <Footer />
        </div>
    );
}
