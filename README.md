调用谷歌翻译服务，英译汉

安装
---
    composer require simaguo/google-translate-api

使用案例
----

    <?php


    require __DIR__ . '/../vendor/autoload.php';

    $client = new Simaguo\GoogleTranslateApi\Client();

    echo $client->translate('navigate');

返回结果

    [
        [
            [
                "导航",
                "navigate",
                null,
                null,
                2
            ],
            [
                null,
                null,
                "Dǎoháng",
                "ˈnaviˌgāt"
            ]
        ],
        [
            [
                "动词",
                [
                    "导航",
                    "航行",
                    "航",
                    "行船"
                ],
                [
                    [
                        "导航",
                        [
                            "navigate"
                        ],
                        null,
                        0.4507353
                    ],
                    [
                        "航行",
                        [
                            "sail",
                            "navigate",
                            "fly"
                        ],
                        null,
                        0.0083855102
                    ],
                    [
                        "航",
                        [
                            "navigate",
                            "sail"
                        ],
                        null,
                        0.0016256054
                    ],
                    [
                        "行船",
                        [
                            "sail",
                            "navigate"
                        ],
                        null,
                        0.000014510689
                    ]
                ],
                "navigate",
                2
            ]
        ],
        "en",
        null,
        null,
        [
            [
                "navigate",
                null,
                [
                    [
                        "导航",
                        1000,
                        true,
                        false
                    ]
                ],
                [
                    [
                        0,
                        8
                    ]
                ],
                "navigate",
                0,
                0
            ]
        ],
        1,
        null,
        [
            [
                "en"
            ],
            null,
            [
                1
            ],
            [
                "en"
            ]
        ],
        null,
        null,
        [
            [
                "动词",
                [
                    [
                        [
                            "steer",
                            "pilot",
                            "guide",
                            "direct",
                            "helm",
                            "captain",
                            "con",
                            "skipper"
                        ],
                        "m_en_us1270693.007"
                    ],
                    [
                        [
                            "sail across/over",
                            "sail",
                            "travel/journey/voyage across/over",
                            "cross",
                            "traverse",
                            "negotiate",
                            "pass"
                        ],
                        "m_en_us1270693.006"
                    ],
                    [
                        [
                            "map-read",
                            "give directions",
                            "plan the route"
                        ],
                        "m_en_us1270693.004"
                    ],
                    [
                        [
                            "voyage",
                            "sail"
                        ],
                        ""
                    ],
                    [
                        [
                            "pilot"
                        ],
                        ""
                    ]
                ],
                "navigate"
            ]
        ],
        [
            [
                "动词",
                [
                    [
                        "plan and direct the route or course of a ship, aircraft, or other form of transportation, especially by using instruments or maps.",
                        "m_en_us1270693.001",
                        "they navigated by the stars"
                    ],
                    [
                        "sail or travel over (a stretch of water or terrain), especially carefully or with difficulty.",
                        "m_en_us1270693.006",
                        "ships had been lost while navigating the narrows"
                    ]
                ],
                "navigate"
            ]
        ],
        [
            [
                [
                    "Since medieval times, mariners have employed dead reckoning to <b>navigate</b> their vessels.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.007"
                ],
                [
                    "whales use their own inbuilt sonar system to <b>navigate</b>",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.003"
                ],
                [
                    "This system permits the operator to <b>navigate</b> along pipeline planned routes and log the GPS coordinates of the aircraft's trajectory.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.002"
                ],
                [
                    "But at some point in the flight radio contact is believed to have been lost when the aircraft was apparently trying to <b>navigate</b> around bad weather.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.005"
                ],
                [
                    "But we've found that chickens will use the sun to <b>navigate</b> over distances of just a couple of metres.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.003"
                ],
                [
                    "Indeed ships used to <b>navigate</b> by the sounds of turtles hitting their hulls and that's how they knew they were getting close to land at night.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.005"
                ],
                [
                    "he taught them how to <b>navigate</b> across the oceans",
                    null,
                    null,
                    null,
                    3,
                    "m_en_gb0550410.002"
                ],
                [
                    "GPS allows you to <b>navigate</b> safely, even when caught in a heavy fog or other bad weather conditions.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.001"
                ],
                [
                    "software used to <b>navigate</b> the Internet",
                    null,
                    null,
                    null,
                    3,
                    "m_en_gb0550410.005"
                ],
                [
                    "Then the bath was ready and the knight drew him to his feet and helped him <b>navigate</b> the wooden steps into the tub.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.006"
                ],
                [
                    "Entrants have to create vehicles that propel themselves, steer, <b>navigate</b> and negotiate potholes, ravines, sand dunes and boulders without any human intervention.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.001"
                ],
                [
                    "Researchers now acknowledge that there is no one simple unified theory of how birds can <b>navigate</b> so precisely.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.003"
                ],
                [
                    "Pilots must <b>navigate</b> their aircraft at least three times every 90 days and have a health check-up every 24 months.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.007"
                ],
                [
                    "My companion here will use a light spell if that's what's needed to <b>navigate</b> in the dark!",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.001"
                ],
                [
                    "This variation is not trivial functionally, because these sensory hairs help the insect <b>navigate</b> through the air.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.003"
                ],
                [
                    "It is planning to withdraw the pilots' authorisation to <b>navigate</b> vessels in the estuary on January 27 when their working contracts run out.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.007"
                ],
                [
                    "Vehicles must decide how to <b>navigate</b> and avoid these obstacles while traveling at 10 to 30 miles per hour.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.001"
                ],
                [
                    "Other animals are also thought to <b>navigate</b> using magnetite.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.003"
                ],
                [
                    "Employers and pension fund trustees have been warned to think carefully about how to <b>navigate</b> the law changes on pensions.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.006"
                ],
                [
                    "the new layout makes it easier to <b>navigate</b> through their atlas of world maps",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.009"
                ],
                [
                    "A study for protest group Friends of the River claims that, as well as flooding farmland, the river would become hard to <b>navigate</b> , damaging sailing, local tourism and a range of businesses.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.006"
                ],
                [
                    "They learned how to build ships and <b>navigate</b> by the stars - perhaps even inheriting a tentative map of the globe.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.001"
                ],
                [
                    "The birds <b>navigate</b> with sound waves bounced off walls and crevices, so the air is filled with the clicks of flyers along with the peeps of the chicks.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.003"
                ],
                [
                    "I speak as a man who can get lost in his own living room, a driver who for years depended on his then wife to <b>navigate</b> on every trip we took.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.004"
                ],
                [
                    "Motorists have to <b>navigate</b> between potholes when using either routes and the surface of the roadway has disintegrated in places.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.002"
                ],
                [
                    "Insects <b>navigate</b> by smell to find food, mates and, in the case of disease-spreading mosquitoes, humans to bite.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.003"
                ],
                [
                    "The record industry now has a chance to <b>navigate</b> these uncharted waters.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.006"
                ],
                [
                    "we'll go in my car—you can <b>navigate</b>",
                    null,
                    null,
                    null,
                    3,
                    "m_en_gb0550410.004"
                ],
                [
                    "It is easy to monitor one net or many nets using the touch screen device to <b>navigate</b> between the systems.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.009"
                ],
                [
                    "Whales <b>navigate</b> hundreds of miles using a mental map of the sea floor based on sound, scientists revealed yesterday.",
                    null,
                    null,
                    null,
                    3,
                    "m_en_us1270693.003"
                ]
            ]
        ]
    ]