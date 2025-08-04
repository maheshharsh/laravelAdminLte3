import { ReactNode, useEffect, useState } from "react";
import Navbar from "../components/Navbar";
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
        <div className="flex flex-col min-h-screen">
            {/* Navbar */}
            <Navbar currentRoute={currentRoute} />

            {/* Main Content Area */}
            <div className="flex flex-col lg:flex-row flex-1 overflow-hidden">
                {/* Mobile-only Advertisements - Displayed at the top on mobile */}
                <div className="block lg:hidden w-full px-4 py-1 mt-14">
                    {advertisements.length > 0 ? (
                        advertisements.map((ad) => (
                            <Advertisement
                                key={ad.id}
                                adv_image={ad.adv_image ?? undefined}
                                title={ad.title}
                            />
                        ))
                    ) : (
                        <Advertisement
                            adv_image={undefined}
                            title="Placeholder Ad"
                        />
                    )}
                </div>

                {/* Left Advertisements - Hidden on mobile, scrollable on desktop */}
                <div className="hidden lg:block lg:w-1/6 fixed left-0 top-16 bottom-0 z-40 overflow-y-auto space-y-2">
                    {leftAds.map((ad) => (
                        <Advertisement
                            key={ad.id}
                            adv_image={ad.adv_image ?? undefined}
                            title={ad.title}
                        />
                    ))}
                </div>

                {/* Main Content - Full width on mobile, centered on desktop */}
                <main className="w-full lg:w-4/6 mx-auto overflow-y-auto px-4 pt-4 lg:pt-20 pb-4">
                    {children}
                </main>

                {/* Right Advertisements - Hidden on mobile, scrollable on desktop */}
                <div className="hidden lg:block lg:w-1/6 fixed right-0 top-16 bottom-0 z-40 overflow-y-auto space-y-2">
                    {rightAds.map((ad) => (
                        <Advertisement
                            key={ad.id}
                            adv_image={ad.adv_image ?? undefined}
                            title={ad.title}
                        />
                    ))}
                </div>
            </div>
        </div>
    );
}
