import {useState, useEffect} from 'react';
import {motion} from 'framer-motion';

import {MenuButton} from "../components/MenuButton.tsx";
import {Spotlight} from "../components/ui/Spotlight.tsx";
import {WobbleCard} from "../components/ui/wobble-card.tsx";

const Header = () => {
    return (
        <header className="container mx-auto px-4 py-20 md:py-16 lg:py-8 xl:py-4 2xl:py-0 overflow-hidden">
            <Spotlight
                className="-top-40 left-0 md:left-60 md:-top-20"
                fill="white"
            />
            <div className="flex flex-col md:flex-row items-center justify-between">
                <motion.div
                    className="w-full md:w-1/2 mb-8 text-center md:text-left"
                    initial={{opacity: 0, y: 50}}
                    animate={{opacity: 1, y: 0}}
                    transition={{duration: 0.8, ease: "easeOut"}}
                >
                    <motion.h1
                        className="text-4xl xxs:text-5xl md:text-6xl lg:text-6xl text-white font-bold leading-tight mb-4"
                        initial={{opacity: 0, y: 20}}
                        animate={{opacity: 1, y: 0}}
                        transition={{delay: 0.2, duration: 0.8, ease: "easeOut"}}
                    >
                        Приумножь свои <br/>
                        <motion.span
                            className="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-green-400"
                            initial={{backgroundPosition: "200% 0"}}
                            animate={{backgroundPosition: "0% 0"}}
                            transition={{duration: 1.5, ease: "easeInOut"}}
                        >
                            средства
                        </motion.span>
                    </motion.h1>
                    <motion.p
                        className="text-lg xs:text-xl md:text-2xl text-gray-300 mb-8"
                        initial={{opacity: 0, y: 20}}
                        animate={{opacity: 1, y: 0}}
                        transition={{delay: 0.4, duration: 0.8, ease: "easeOut"}}
                    >
                        Начните инвестировать в Venture Vigil и приумножайте свои деньги вместе с нами.
                    </motion.p>
                    <motion.div
                        className="flex justify-center md:justify-start items-center space-x-4"
                        initial={{opacity: 0, y: 20}}
                        animate={{opacity: 1, y: 0}}
                        transition={{delay: 0.6, duration: 0.8, ease: "easeOut"}}
                    >
                        <a href="/register">
                            <motion.button
                                className="bg-gradient-to-r from-cyan-500 to-green-500 rounded-sm px-4 xxs:px-6 py-3 text-white font-semibold transition-all duration-300 ease-in-out hover:shadow-lg hover:shadow-green-500/40 hover:translate-y-[-2px] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                whileHover={{scale: 1.05}}
                                whileTap={{scale: 0.95}}
                            >
                                Начать
                            </motion.button>
                        </a>

                        <span className="text-white font-medium">или</span>
                        <a href="/login">
                            <motion.button
                                className="px-4 xxs:px-6 py-3 bg-gray-800 text-white font-semibold border border-gray-600 rounded-sm transition-all duration-300 ease-in-out hover:bg-gray-700 hover:border-gray-500 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50"
                                whileHover={{scale: 1.05}}
                                whileTap={{scale: 0.95}}
                            >
                                Войти
                            </motion.button>
                        </a>

                    </motion.div>
                </motion.div>
                <motion.div
                    className="w-1/2 lg:w-1/3 justify-center hidden md:block"
                    initial={{opacity: 0, x: 100}}
                    animate={{opacity: 1, x: 0}}
                    transition={{duration: 0.8, ease: "easeOut"}}
                >
                    <motion.img
                        src="/images/hero-banner.svg"
                        alt="Мужчина, достигающий своих финансовых целей"
                        className="max-w-full h-auto rounded-lg"
                        whileHover={{scale: 1.05, rotate: 5}}
                        transition={{type: "spring", stiffness: 300, damping: 10}}
                    />
                </motion.div>
            </div>
        </header>
    );
};

const ParallaxSection = () => {
    const [userCount, setUserCount] = useState(9876);

    useEffect(() => {
        const interval = setInterval(() => {
            setUserCount(prevCount => prevCount + 1);
        }, 5000); // Increase count every 5 seconds

        return () => clearInterval(interval);
    }, []);

    return (
        <section className="relative h-fit overflow-hidden bg-fixed bg-cover bg-center"
                 style={{backgroundImage: "url('/images/stock.webp')"}}>
            <div className="absolute inset-0 bg-black bg-opacity-65"/>
            <div className="relative z-10 h-full flex flex-col items-center justify-center text-white py-20">
                <h2 className="text-4xl md:text-5xl font-bold mb-8 text-center px-4">Присоединяйтесь к нашему растущему
                    сообществу</h2>
                <div className="text-6xl md:text-7xl font-bold mb-4">
                    {userCount.toLocaleString()}
                </div>
                <p className="text-xl md:text-2xl">инвесторов уже с нами</p>
            </div>
        </section>
    );
};

const AnalyticsSection = () => {
    return (
        <section className="py-16 md:py-24 bg-gray-900">
            <div className="container mx-auto px-4">
                <h2 className="text-3xl md:text-4xl font-bold text-center text-white mb-12">
                    Персональная рыночная <span
                    className="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-green-400">аналитика</span>
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div className="bg-gray-800 rounded-lg p-6 shadow-lg">
                        <div className="text-cyan-400 text-4xl mb-4">1</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Безопасно внесите средства</h3>
                        <p className="text-gray-400">Начните с внесения средств на ваш счет в Venture Vigil. Ваш
                            капитал находится в безопасности и готов к умным инвестициям.</p>
                    </div>
                    <div className="bg-gray-800 rounded-lg p-6 shadow-lg">
                        <div className="text-cyan-400 text-4xl mb-4">2</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Экспертный совет</h3>
                        <p className="text-gray-400">Наши опытные профессионалы предоставляют персонализированные
                            инвестиционные рекомендации
                            на основе текущих рыночных тенденций и ваших целей.</p>
                    </div>
                    <div className="bg-gray-800 rounded-lg p-6 shadow-lg">
                        <div className="text-cyan-400 text-4xl mb-4">3</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Платите только за успех</h3>
                        <p className="text-gray-400">Мы взимаем небольшие комиссии только тогда, когда наши советы
                            приводят к успешным
                            инвестициям. Ваш успех - это наш успех.</p>
                    </div>
                </div>
                <div className="text-center">
                    <a href="/register">
                        <button
                            className="bg-gradient-to-r from-cyan-500 to-green-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1">
                            Начните свой путь
                        </button>
                    </a>
                </div>
            </div>
        </section>
    );
};

const FeatureSection = () => {
    const features = [
        {
            title: "Умные инвестиции",
            description: "Наша платформа, управляемая опытными профессионалами, оптимизирует ваш портфель для максимальной доходности.",
            icon: (
                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            ),
        },
        {
            title: "Безопасные транзакции",
            description: "Шифрование банковского уровня обеспечивает постоянную защиту ваших инвестиций.",
            icon: (
                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            ),
        },
        {
            title: "Экспертное руководство",
            description: "Доступ к финансовым консультантам, которые помогут вам принимать обоснованные решения.",
            icon: (
                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            ),
        },
    ];

    return (
        <section className="py-16 md:py-28 bg-gray-900">
            <div className="container mx-auto px-0.5 xs:px-1 sm:px-4">
                <h2 className="text-3xl md:text-4xl font-bold text-center text-white mb-16">
                    Почему стоит выбрать <span
                    className="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-green-400">Venture Vigil</span>
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {features.map((feature, index) => (
                        <WobbleCard key={index} containerClassName="min-h-[300px]" noiseFilename="noise3.webp">
                            <div className="p-6 h-full flex flex-col justify-between">
                                <div>
                                    <div className="mb-4">{feature.icon}</div>
                                    <h3 className="text-xl font-semibold text-white mb-2">{feature.title}</h3>
                                    <p className="text-gray-200">{feature.description}</p>
                                </div>
                                <a href="/register">
                                    <button
                                        className="mt-4 bg-white text-gray-900 px-4 py-2 rounded-md font-semibold hover:bg-gray-200 transition-colors duration-300">
                                        Начать
                                    </button>
                                </a>

                            </div>
                        </WobbleCard>
                    ))}
                </div>
                <WobbleCard containerClassName="col-span-1 md:col-span-3 min-h-[300px] mt-8 hidden md:flex">
                    <div className="p-6 h-full flex flex-col md:flex-row items-center justify-between">
                        <div className="md:max-w-xl">
                            <h2 className="text-2xl md:text-3xl font-semibold text-white mb-4">
                                Начните свой инвестиционный путь сегодня
                            </h2>
                            <p className="text-gray-200 mb-6">
                                Присоединяйтесь к тысячам инвесторов, которые доверяют Venture Vigil свой финансовый
                                рост. Наша передовая платформа, управляемая опытными профессионалами, разработана для
                                максимизации ваших доходов при минимизации рисков.
                            </p>
                        </div>
                        <a href="/register">
                            <button
                                className="mt-4 bg-white text-gray-900 px-4 py-2 rounded-md font-semibold hover:bg-gray-200 transition-colors duration-300">
                                Начать
                            </button>
                        </a>
                    </div>
                </WobbleCard>
            </div>
        </section>
    );
};

const ContactSection = () => {
    const [formState, setFormState] = useState({
        first_name: '',
        last_name: '',
        phone: '',
    });

    const [submissionStatus, setSubmissionStatus] = useState({
        isSubmitting: false,
        isSuccess: false,
        error: null
    });

    const handleInputChange = (e) => {
        const {name, value} = e.target;
        setFormState(prev => ({...prev, [name]: value}));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSubmissionStatus({ isSubmitting: true, isSuccess: false, error: null });

        try {
            const response = await fetch(`http://venture-givil/api/callback-form`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formState),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            console.log('Success:', data);
            setSubmissionStatus({ isSubmitting: false, isSuccess: true, error: null });
            setFormState({ first_name: '', last_name: '', phone: '' });
        } catch (error) {
            console.error('Error:', error);
            setSubmissionStatus({ isSubmitting: false, isSuccess: false, error: error.message });
        }
    };

    return (
        <section className="py-16 md:py-24 bg-gray-900">
            <div className="container mx-auto px-4">
                <h2 className="text-3xl md:text-4xl font-bold text-center text-white mb-16">
                    Мы свяжемся с <span
                    className="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-green-400">Вами</span>
                </h2>
                <div className="">
                    <motion.div
                        className="w-full md:w-1/2 xl:w-1/3 mx-auto"
                        initial={{opacity: 0, x: -50}}
                        animate={{opacity: 1, x: 0}}
                        transition={{duration: 0.5}}
                    >
                        <form onSubmit={handleSubmit} className="space-y-6">
                            <div>
                                <label htmlFor="firstname"
                                       className="block text-sm font-medium text-gray-300">Имя</label>
                                <input
                                    type="text"
                                    id="firstname"
                                    name="first_name"
                                    value={formState.first_name}
                                    onChange={handleInputChange}
                                    required
                                    className="mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                />
                            </div>
                            <div>
                                <label htmlFor="lastname"
                                       className="block text-sm font-medium text-gray-300">Фамилия</label>
                                <input
                                    type="text"
                                    id="lastname"
                                    name="last_name"
                                    value={formState.last_name}
                                    onChange={handleInputChange}
                                    required
                                    className="mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                />
                            </div>
                            <div>
                                <label htmlFor="phone"
                                       className="block text-sm font-medium text-gray-300">Телефон</label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value={formState.phone}
                                    onChange={handleInputChange}
                                    placeholder="+7 (999) 999-99-99"
                                    required
                                    className="mt-1 block w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                />
                            </div>

                            <motion.button
                                type="submit"
                                className="w-full px-4 py-2 bg-gradient-to-r from-cyan-500 to-green-500 text-white font-bold rounded-md shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1"
                                whileHover={{scale: 1.05}}
                                whileTap={{scale: 0.95}}
                                disabled={submissionStatus.isSubmitting}
                            >
                                {submissionStatus.isSubmitting ? 'Отправка...' : 'Перезвоните мне'}
                            </motion.button>
                        </form>
                    </motion.div>
                    <div className="mt-8">
                        {submissionStatus.isSuccess && (
                            <div className="mt-4 p-2 bg-green-500 text-white rounded">
                                Спасибо за ваше сообщение! Мы свяжемся с вами в ближайшее время.
                            </div>
                        )}
                        {submissionStatus.error && (
                            <div className="mt-4 p-2 bg-red-500 text-white rounded">
                                Произошла ошибка: {submissionStatus.error}. Пожалуйста, попробуйте еще раз.
                            </div>
                        )}
                    </div>

                </div>
            </div>
        </section>
    );
};

const AdditionalFeaturesSection = () => {
    return (
        <section id="additional_features" className="py-16 md:py-24 bg-gray-900">
            <div className="container mx-auto px-4">
                <h2 className="text-3xl md:text-4xl font-bold text-center text-white mb-12">
                    Что такое <span
                    className="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-green-400">Venture Vigil</span>
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {[
                        {
                            title: "Умные инвестиции",
                            description: "Наша платформа, управляемая профессионалами, оптимизирует ваш портфель для максимальной доходности.",
                            icon: (
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-cyan-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            ),
                        },
                        {
                            title: "Безопасные транзакции",
                            description: "Шифрование банковского уровня обеспечивает постоянную защиту ваших инвестиций.",
                            icon: (
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-green-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            ),
                        },
                        {
                            title: "Экспертное руководство",
                            description: "Доступ к финансовым консультантам, которые помогут вам принимать обоснованные решения.",
                            icon: (
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-cyan-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            ),
                        },
                        {
                            title: "Диверсифицированный портфель",
                            description: "Распределите свои инвестиции по различным активам, чтобы минимизировать риски.",
                            icon: (
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-green-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            ),
                        },
                        {
                            title: "Аналитика в реальном времени",
                            description: "Следите за своими инвестициями с помощью обновлений в реальном времени и детальных отчетов.",
                            icon: (
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-cyan-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            ),
                        },
                        {
                            title: "Поддержка 24/7",
                            description: "Наша преданная команда всегда готова помочь вам с любыми вопросами.",
                            icon: (
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-12 w-12 text-green-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            ),
                        },
                    ].map((feature, index) => (
                        <div key={index}
                             className="bg-gray-800 rounded-lg p-6 shadow-lg transform transition duration-500 hover:scale-105">
                            <div
                                className="flex items-center justify-center w-16 h-16 bg-gray-700 rounded-full mb-4">
                                {feature.icon}
                            </div>
                            <h3 className="text-xl font-semibold text-white mb-2">{feature.title}</h3>
                            <p className="text-gray-400">{feature.description}</p>
                        </div>
                    ))}
                </div>
                <div className="mt-12 text-center">
                    <h3 className="text-2xl font-semibold text-white mb-4">Готовы начать свое инвестиционное
                        путешествие?</h3>
                    <a href="/register">

                        <button
                            className="bg-gradient-to-r from-cyan-500 to-green-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1">
                            Зарегистрироваться сейчас
                        </button>
                    </a>
                </div>
            </div>
        </section>
    )
}

const Footer = () => {
    return (
        <footer
            className="bg-gray-900 text-white py-12 hidden"
        >
            <div className="container mx-auto px-4">
                <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 className="text-lg font-semibold mb-4">About Venture Vigil</h3>
                        <p className="text-gray-400">Empowering investors with AI-driven insights and secure investment
                            opportunities.</p>
                    </div>
                    <div>
                        <h3 className="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul className="space-y-2">
                            <li><a href="#" className="text-gray-400 hover:text-white transition-colors">Home</a></li>
                            <li><a href="#" className="text-gray-400 hover:text-white transition-colors">About Us</a>
                            </li>
                            <li><a href="#" className="text-gray-400 hover:text-white transition-colors">Services</a>
                            </li>
                            <li><a href="#" className="text-gray-400 hover:text-white transition-colors">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 className="text-lg font-semibold mb-4">Legal</h3>
                        <ul className="space-y-2">
                            <li><a href="#" className="text-gray-400 hover:text-white transition-colors">Terms of
                                Service</a></li>
                            <li><a href="#" className="text-gray-400 hover:text-white transition-colors">Privacy
                                Policy</a></li>
                            <li><a href="#" className="text-gray-400 hover:text-white transition-colors">Cookie
                                Policy</a></li>
                            <li><a href="#" className="text-gray-400 hover:text-white transition-colors">Disclaimer</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 className="text-lg font-semibold mb-4">Connect With Us</h3>
                        <div className="flex space-x-4">
                            <a href="#" className="text-gray-400 hover:text-white transition-colors">
                                <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd"
                                          d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                          clipRule="evenodd"/>
                                </svg>
                            </a>
                            <a href="#" className="text-gray-400 hover:text-white transition-colors">
                                <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd"
                                          d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                          clipRule="evenodd"/>
                                </svg>
                            </a>
                            <a href="#" className="text-gray-400 hover:text-white transition-colors">
                                <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div className="mt-8 pt-8 border-t border-gray-800 text-center">
                    <p className="text-gray-400">&copy; 2024 Venture Vigil. All rights reserved.</p>
                </div>
            </div>
        </footer>
    );
};

const Home = () => {
    const [isOpen, setOpen] = useState(false);

    const menuButtonStyle = {
        marginLeft: '3rem',
        marginRight: '1rem',
    };


    return (
        <div
            className="min-h-screen w-full flex flex-col bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700 antialiased">
            <nav className="bg-transparent px-4 lg:px-6 py-2.5">
                <div className="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl sm:space-x-2">
                    {/*Logo*/}
                    <a href="#" className="flex items-center">
                        <svg className="mr-3 block h-9 sm:h-12 w-auto" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 355.000000 350.000000"
                             preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(-120.000000,470.000000) scale(0.100000,-0.100000)" fill="#fff"
                               stroke="none">
                                <path
                                    d="M2845 4644 c-333 -48 -550 -135 -790 -314 -86 -65 -223 -198 -294 -287 l-34 -43 -139 0 c-76 0 -138 -2 -138 -5 0 -3 31 -60 69 -127 l70 -121 -21 -51 c-135 -333 -162 -675 -78 -1001 155 -600 632 -1043 1245 -1154 66 -13 127 -26 135 -30 8 -4 39 -51 69 -105 30 -53 57 -96 60 -96 3 0 33 47 66 105 l60 104 45 7 c362 50 662 191 906 427 272 262 436 598 474 972 24 228 -2 435 -86 689 l-47 142 66 116 c37 64 67 119 67 122 0 3 -63 6 -139 6 l-139 0 -53 63 c-255 302 -547 480 -914 557 -97 20 -383 35 -460 24z m447 -134 c303 -64 582 -224 783 -449 30 -34 55 -66 55 -71 0 -6 -146 -10 -387 -10 -212 0 -383 3 -379 7 4 4 59 26 122 48 64 22 116 45 116 50 1 16 -129 101 -227 149 -200 98 -346 131 -580 131 -189 0 -255 -10 -413 -61 -138 -45 -266 -112 -392 -207 -95 -72 -101 -75 -60 -32 253 267 539 416 890 465 104 14 361 4 472 -20z m-1152 -625 c0 -2 -22 -52 -50 -111 -27 -59 -50 -111 -50 -115 0 -10 657 -1148 671 -1163 5 -6 9 280 9 692 l0 702 115 0 115 0 0 -1132 c0 -648 -4 -1128 -9 -1122 -5 5 -188 320 -406 699 -219 380 -510 883 -647 1118 -136 236 -248 431 -248 433 0 2 113 4 250 4 138 0 250 -2 250 -5z m1140 -697 c0 -454 3 -699 10 -692 5 5 159 268 341 584 377 653 342 564 281 728 l-31 82 239 0 c132 0 240 -2 240 -4 0 -7 -1291 -2241 -1301 -2250 -5 -6 -9 409 -9 1122 l0 1132 115 0 115 0 0 -702z m-1426 107 c87 -154 168 -296 179 -315 25 -42 24 -42 -102 68 -46 39 -87 72 -91 72 -24 0 -27 -286 -4 -421 76 -449 395 -844 811 -1005 40 -15 71 -29 69 -32 -3 -2 -40 6 -83 18 -263 71 -461 186 -654 379 -212 211 -336 443 -401 745 -29 135 -31 397 -4 531 15 78 69 265 83 288 6 11 6 11 197 -328z m2550 135 c85 -345 49 -677 -109 -995 -172 -346 -471 -608 -835 -729 -116 -38 -260 -69 -260 -55 0 11 381 661 385 657 2 -2 -8 -59 -21 -127 -13 -68 -22 -126 -19 -129 10 -11 232 108 310 166 211 156 385 393 465 632 72 214 88 472 44 690 -4 19 -3 21 4 10 6 -8 22 -62 36 -120z"></path>
                            </g>
                        </svg>

                        <span
                            className="text-sm font-bold leading-tight inline-block md:hidden py-2 whitespace-nowrap uppercase text-white"
                        >venture<br/>vigil</span>
                        <span
                            className="text-sm md:text-md font-bold leading-relaxed hidden md:inline-block py-2 whitespace-nowrap uppercase text-white"
                        >venture vigil</span>
                    </a>
                    <div className="flex items-center space-x-3 md:order-2">
                        <a href="/login">
                            <button
                                className="px-3 py-2 hidden sm:block text-white text-sm rounded-md font-semibold hover:bg-gray-800/[0.8] transition-colors duration-200 hover:shadow-lg">
                                Log
                                in
                            </button>
                        </a>


                        <a href="/register">
                            <button className="p-[2px] relative hidden sm:block">
                                <div
                                    className="absolute inset-0 bg-gradient-to-br from-cyan-500 to-green-500 rounded-sm"/>
                                <div
                                    className="px-3.5 py-1 bg-gray-800 rounded-[1.5px] relative group transition duration-200 text-white hover:bg-transparent hover:shadow-md hover:shadow-green-500/40">
                                    Join Us
                                </div>
                            </button>
                        </a>


                        <MenuButton
                            isOpen={isOpen}
                            onClick={() => setOpen(!isOpen)}
                            style={menuButtonStyle}
                            color="var(--gray-50)"
                            className="hidden p-0.5"
                        />
                    </div>
                    <div
                        className={`${isOpen ? 'block' : 'hidden'} justify-between items-center w-full md:w-auto md:order-1`}
                        id="mobile-menu-2">
                        <ul className="flex flex-col mt-4 font-medium md:flex-row md:space-x-8 md:mt-0">
                            <li>
                                <a href="#"
                                   className="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 md:bg-transparent md:text-primary-700 md:p-0 dark:text-white"
                                   aria-current="page">Home</a>
                            </li>
                            <li>
                                <a href="#"
                                   className="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-primary-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Dashboard</a>
                            </li>
                            <li>
                                <a href="#"
                                   className="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-primary-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Orders</a>
                            </li>
                            <li>
                                <a href="#"
                                   className="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-primary-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Cashiers</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <Header/>


            <main className="flex-grow">
                <FeatureSection/>
                <ParallaxSection/>
                <AnalyticsSection/>
                <AdditionalFeaturesSection/>
                <ContactSection/>
            </main>

            <Footer/>
        </div>
    )
}

export default Home;
