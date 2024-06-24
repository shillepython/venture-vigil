"use client";
import {ReactNode, useState, MouseEvent} from "react";
import { motion } from "framer-motion";
import { cn } from "../../../../utils/cn";

export const WobbleCard = ({
                               children,
                               containerClassName,
                                noiseFilename,
                               className,
                           }: {
    children: ReactNode;
    containerClassName?: string;
    noiseFilename?: string;
    className?: string;
}) => {
    const [mousePosition, setMousePosition] = useState({ x: 0, y: 0 });
    const [isHovering, setIsHovering] = useState(false);

    const handleMouseMove = (event: MouseEvent<HTMLElement>) => {
        const { clientX, clientY } = event;
        const rect = event.currentTarget.getBoundingClientRect();
        const x = (clientX - (rect.left + rect.width / 2)) / 20;
        const y = (clientY - (rect.top + rect.height / 2)) / 20;
        setMousePosition({ x, y });
    };
    return (
        <motion.div
            onMouseMove={handleMouseMove}
            onMouseEnter={() => setIsHovering(true)}
            onMouseLeave={() => {
                setIsHovering(false);
                setMousePosition({ x: 0, y: 0 });
            }}
            style={{
                transform: isHovering
                    ? `translate3d(${mousePosition.x}px, ${mousePosition.y}px, 0) scale3d(1, 1, 1)`
                    : "translate3d(0px, 0px, 0) scale3d(1, 1, 1)",
                transition: "transform 0.1s ease-out, background-color 0.5s cubic-bezier(0.19, 1, 0.22, 1)",
            }}
            className={cn(
                "mx-auto w-full md:bg-blue-200/35 md:hover:bg-green-600/90 bg-gray-600/70 transition-colors relative rounded-2xl overflow-hidden",
                containerClassName
            )}
        >
            <div
                className="relative  h-full [background-image:radial-gradient(88%_100%_at_top,rgba(255,255,255,0.5),rgba(255,255,255,0))]  sm:mx-0 sm:rounded-2xl overflow-hidden"
                style={{
                    boxShadow:
                        "0 10px 32px rgba(34, 42, 53, 0.12), 0 1px 1px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(34, 42, 53, 0.05), 0 4px 6px rgba(34, 42, 53, 0.08), 0 24px 108px rgba(47, 48, 55, 0.10)",
                }}
            >
                <motion.div
                    style={{
                        transform: isHovering
                            ? `translate3d(${-mousePosition.x}px, ${-mousePosition.y}px, 0) scale3d(1.03, 1.03, 1)`
                            : "translate3d(0px, 0px, 0) scale3d(1, 1, 1)",
                        transition: "transform 0.1s ease-out",
                    }}
                    className={cn("h-full px-4 py-6 md:py-12 sm:px-10", className)}
                >
                    <Noise file={noiseFilename} className="hidden" />
                    {children}
                </motion.div>
            </div>
        </motion.div>
    );
};

const Noise = ({file, className} : {
    file?: string;
    className?: string;
}) => {
    return (
        <div
            className={cn('absolute inset-0 w-full h-full scale-[1.2] transform opacity-10 [mask-image:radial-gradient(#fff,transparent,75%)]', className)}
            style={{
                backgroundImage: `url(/images/${file || "noise.webp"})`,
                backgroundSize: "cover",
            }}
        ></div>
    );
};
