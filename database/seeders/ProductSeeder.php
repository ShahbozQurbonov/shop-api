<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->products() as $item) {
            $product = Product::create([
                'category_id' => $item['category_id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'description' => $item['description'],
            ]);

            foreach ($this->buildStocks($item['stock_profile'], $item['price']) as $stock) {
                $product->stocks()->create($stock);
            }
        }
    }

    private function products(): array
    {
        return [
            $this->product(1, 3890, 'smartphone', 'Aster X10 128GB', 'Смартфони муосир бо экрани равшан ва камераи қулай.', 'Современный смартфон с ярким экраном и удобной камерой.', 'Zamonaviy ekran va qulay kameraga ega smartfon.'),
            $this->product(1, 4290, 'smartphone', 'Aster X10 Pro 256GB', 'Модели пурқувват барои наворбардорӣ ва шабакаҳои иҷтимоӣ.', 'Мощная модель для съемки и социальных сетей.', 'Kontent va kundalik foydalanish uchun kuchli model.'),
            $this->product(1, 5120, 'smartphone', 'Nova S22', 'Смартфон бо батареяи дарозмуддат ва хотираи калон.', 'Смартфон с долгой батареей и большим объемом памяти.', 'Katta xotira va uzoq ishlaydigan batareyali smartfon.'),
            $this->product(1, 4680, 'smartphone', 'Nova S22 Plus', 'Версияи Plus барои онҳое, ки экрани калон мехоҳанд.', 'Версия Plus для тех, кому нужен большой экран.', 'Katta ekran xohlaganlar uchun Plus versiya.'),
            $this->product(1, 5980, 'smartphone', 'Orion Max 5G', 'Смартфони 5G бо тарҳи борик ва кори устувор.', 'Смартфон 5G с тонким дизайном и стабильной работой.', 'Yupqa dizaynli va barqaror ishlaydigan 5G smartfon.'),

            $this->product(2, 7390, 'laptop', 'Vertex Book 14', 'Ноутбуки сабук барои таҳсил ва кори офисӣ.', 'Легкий ноутбук для учебы и офисной работы.', 'O‘qish va ofis ishlari uchun yengil noutbuk.'),
            $this->product(2, 8840, 'laptop', 'Vertex Book 15 Pro', 'Ноутбук барои корбарони фаъол бо SSD ва RAM баланд.', 'Ноутбук для активных пользователей с быстрым SSD и большим RAM.', 'Faol foydalanuvchilar uchun tezkor noutbuk.'),
            $this->product(2, 12600, 'laptop', 'Titan Workstation 16', 'Ноутбуки истеҳсолӣ барои монтаж ва кор бо графика.', 'Производительный ноутбук для монтажа и графики.', 'Montaj va grafika uchun unumdor noutbuk.'),
            $this->product(2, 9680, 'laptop', 'Swift Air 13', 'Ултрабуки борик барои сафар ва мулоқотҳои корӣ.', 'Тонкий ультрабук для поездок и деловых встреч.', 'Safar va uchrashuvlar uchun ultrabuk.'),
            $this->product(2, 10900, 'laptop', 'CodeMaster 15', 'Ноутбук барои барномасозон ва multitasking.', 'Ноутбук для разработчиков и многозадачности.', 'Dasturchilar va ko‘p vazifa uchun noutbuk.'),

            $this->product(3, 5680, 'tv', 'Vision TV 42', 'Телевизори Smart барои меҳмонхонаҳои миёнаҳаҷм.', 'Smart телевизор для гостиной среднего размера.', 'O‘rtacha mehmonxona uchun Smart TV.'),
            $this->product(3, 7420, 'tv', 'Vision TV 55', 'Телевизор бо ранги равшан ва садои тоза.', 'Телевизор с ярким цветом и чистым звуком.', 'Yorqin tasvir va toza ovozli televizor.'),
            $this->product(3, 9860, 'tv', 'Cinema Pro 65', 'Телевизори калон барои кино ва варзиш.', 'Большой телевизор для кино и спорта.', 'Film va sport uchun katta televizor.'),
            $this->product(3, 8130, 'tv', 'Cinema Pro 55', 'Модели 4K барои истифодаи ҳаррӯза ва YouTube.', 'Модель 4K для ежедневного просмотра и YouTube.', 'Har kuni foydalanish uchun 4K model.'),
            $this->product(3, 11400, 'tv', 'UltraView Max 65', 'Телевизори премиум бо тарҳи борик.', 'Премиальный телевизор с тонким корпусом.', 'Yupqa korpusli premium televizor.'),

            $this->product(4, 8290, 'fridge', 'Polar Fresh 320L', 'Яхдони дуқабата барои оилаи миёна.', 'Двухкамерный холодильник для средней семьи.', 'O‘rtacha oila uchun ikki kamerali muzlatgich.'),
            $this->product(4, 9140, 'fridge', 'Polar Fresh Inverter', 'Модели сарфакор бо технологияи inverter.', 'Экономичная модель с инверторной технологией.', 'Tejamkor inverter muzlatgich.'),
            $this->product(4, 10900, 'fridge', 'Arctic Home 420L', 'Яхдони калон бо рафҳои бароҳат.', 'Вместительный холодильник с удобными полками.', 'Keng va qulay tokchali muzlatgich.'),
            $this->product(4, 12400, 'fridge', 'Arctic Glass Premium', 'Модели премиум бо намуди шишаӣ.', 'Премиальная модель со стеклянным фасадом.', 'Shisha old panelli premium model.'),
            $this->product(4, 9680, 'fridge', 'CoolSpace Duo', 'Яхдони хонагӣ бо садои паст.', 'Домашний холодильник с низким уровнем шума.', 'Shovqini past uy muzlatgichi.'),

            $this->product(5, 6240, 'washer', 'WashPro 7kg', 'Мошинаи автоматӣ барои истифодаи ҳаррӯза.', 'Автоматическая стиральная машина для ежедневного использования.', 'Har kungi foydalanish uchun avtomat kir yuvish mashinasi.'),
            $this->product(5, 7180, 'washer', 'WashPro 8kg Inverter', 'Модели inverter барои хонаводаҳои фаъол.', 'Инверторная модель для активной семьи.', 'Faol oila uchun inverter model.'),
            $this->product(5, 7890, 'washer', 'CleanWave 9kg', 'Ҳаҷми калон барои кӯрпа ва либосҳои зиёдатӣ.', 'Большой объем для пледов и объемной одежды.', 'Ko‘rpa va katta kiyimlar uchun keng hajm.'),
            $this->product(5, 6840, 'washer', 'CleanWave Slim', 'Модели борик барои ҳаммом ва ошхонаи хурд.', 'Узкая модель для небольшой ванной или кухни.', 'Kichik joylar uchun ixcham model.'),
            $this->product(5, 8420, 'washer', 'PureSpin Premium', 'Мошинаи сатҳи боло бо барномаҳои зиёд.', 'Премиальная машина с большим набором программ.', 'Ko‘p dasturli premium kir yuvish mashinasi.'),

            $this->product(6, 5480, 'ac', 'AirCool 12', 'Кондиционер барои утоқи то 20 м².', 'Кондиционер для комнаты до 20 м².', '20 m² gacha xona uchun konditsioner.'),
            $this->product(6, 6120, 'ac', 'AirCool 18 Inverter', 'Модели inverter барои хунуккунӣ ва гармкунӣ.', 'Инверторная модель для охлаждения и обогрева.', 'Sovutish va isitish uchun inverter model.'),
            $this->product(6, 7290, 'ac', 'Breeze Max 24', 'Кондиционер барои меҳмонхона ва идораҳои калон.', 'Кондиционер для большой гостиной или офиса.', 'Katta xona va ofis uchun konditsioner.'),
            $this->product(6, 6680, 'ac', 'Breeze Max 18', 'Модели тавозуншуда барои истифодаи чор фасл.', 'Сбалансированная модель для круглогодичного использования.', 'To‘rt fasl foydalanish uchun model.'),
            $this->product(6, 7850, 'ac', 'Climate Pro 24', 'Кондиционери сатҳи боло бо филтри беҳтар.', 'Модель высокого класса с улучшенной фильтрацией.', 'Yaxshi filtrli yuqori sinf konditsioner.'),

            $this->product(7, 890, 'headphone', 'SoundBeat Lite', 'Гӯшмонаки сабук барои мусиқӣ ва зангҳо.', 'Легкие наушники для музыки и звонков.', 'Musiqa va qo‘ng‘iroq uchun yengil quloqchin.'),
            $this->product(7, 1240, 'headphone', 'SoundBeat Pro', 'Гӯшмонаки Bluetooth бо микрофони хуб.', 'Bluetooth наушники с качественным микрофоном.', 'Yaxshi mikrofonli Bluetooth quloqchin.'),
            $this->product(7, 1680, 'headphone', 'BassCore Max', 'Модел барои дӯстдорони бас ва подкаст.', 'Модель для любителей баса и подкастов.', 'Bas va podkast sevuvchilar uchun model.'),
            $this->product(7, 2140, 'headphone', 'NoiseZero ANC', 'Гӯшмонак бо фурӯнишонии садо.', 'Наушники с активным шумоподавлением.', 'Shovqinni kamaytiruvchi quloqchin.'),
            $this->product(7, 1490, 'headphone', 'Studio Pods', 'Гӯшмонаки дохилигӯшӣ барои сафар ва кор.', 'Внутриканальные наушники для поездок и работы.', 'Safar va ish uchun qulay quloqchin.'),

            $this->product(8, 1590, 'smartwatch', 'WristGo S1', 'Соати ҳушманд барои қадам ва огоҳиномаҳо.', 'Смарт-часы для шагов и уведомлений.', 'Qadam va bildirishnomalar uchun smart soat.'),
            $this->product(8, 1980, 'smartwatch', 'WristGo S1 Pro', 'Модели беҳтар бо мониторинги хоб ва набз.', 'Улучшенная модель с мониторингом сна и пульса.', 'Uyqu va yurak urishini kuzatuvchi model.'),
            $this->product(8, 2240, 'smartwatch', 'Active Watch 2', 'Соат барои машқ ва истифодаи ҳаррӯза.', 'Часы для тренировок и ежедневного ношения.', 'Mashq va kundalik foydalanish uchun soat.'),
            $this->product(8, 2670, 'smartwatch', 'Active Watch 2 Max', 'Модели калонтар бо батареяи бештар.', 'Увеличенная версия с более емкой батареей.', 'Batareyasi kattaroq model.'),
            $this->product(8, 3120, 'smartwatch', 'Health Pro X', 'Соати премиум бо корпуси мустаҳкам.', 'Премиальные часы с прочным корпусом.', 'Mustahkam korpusli premium smart soat.'),

            $this->product(9, 5860, 'camera', 'PixelCam M50', 'Камера барои блог ва аксбардории рӯзмарра.', 'Камера для блога и повседневной съемки.', 'Blog va kundalik suratlar uchun kamera.'),
            $this->product(9, 7420, 'camera', 'PixelCam M50 Pro', 'Версияи Pro бо фокуси зуд ва видео 4K.', 'Версия Pro с быстрым фокусом и видео 4K.', 'Tez fokus va 4K video bilan Pro versiya.'),
            $this->product(9, 9180, 'camera', 'FrameShot X', 'Камера барои студия ва наворбардории касбӣ.', 'Камера для студии и более профессиональной съемки.', 'Studiya va professional suratga olish uchun kamera.'),
            $this->product(9, 10600, 'camera', 'FrameShot X Max', 'Модели боло бо корпуси устувор.', 'Старшая модель с прочным корпусом.', 'Mustahkam korpusli yuqori model.'),
            $this->product(9, 6740, 'camera', 'TravelCam Zoom', 'Камера барои сафар ва аксҳои оилавӣ.', 'Камера для путешествий и семейных кадров.', 'Sayohat va oilaviy kadrlar uchun kamera.'),

            $this->product(10, 1720, 'vacuum', 'DustFree Compact', 'Чангкашак барои квартира ва истифодаи зуд.', 'Пылесос для квартиры и быстрой уборки.', 'Kvartira uchun qulay changyutgich.'),
            $this->product(10, 2140, 'vacuum', 'DustFree Turbo', 'Қувваи хуб барои қолин ва фарши сахт.', 'Хорошая мощность для ковра и твердого пола.', 'Gilam va qattiq pol uchun kuchli model.'),
            $this->product(10, 2980, 'vacuum', 'CleanBot Home', 'Чангкашаки интеллектуалӣ барои тозакунии сабук.', 'Умный пылесос для повседневной уборки.', 'Har kungi tozalash uchun aqlli changyutgich.'),
            $this->product(10, 2640, 'vacuum', 'PowerClean Pro', 'Модели қавӣ барои хонаҳои калон.', 'Мощная модель для домов большей площади.', 'Katta uylar uchun kuchli changyutgich.'),
            $this->product(10, 3380, 'vacuum', 'PowerClean Premium', 'Чангкашак бо филтри беҳтар ва садои паст.', 'Пылесос с улучшенной фильтрацией и тихой работой.', 'Yaxshi filtrli va sokin ishlaydigan changyutgich.'),
        ];
    }

    private function product(int $categoryId, int $price, string $profile, string $name, string $tj, string $ru, string $uz): array
    {
        return [
            'category_id' => $categoryId,
            'price' => $price,
            'stock_profile' => $profile,
            'name' => ['tj' => $name, 'ru' => $name, 'uz' => $name],
            'description' => ['tj' => $tj, 'ru' => $ru, 'uz' => $uz],
        ];
    }

    private function buildStocks(string $profile, int $price): array
    {
        $profiles = [
            'smartphone' => [
                ['color_id' => 1, 'variant_id' => 7, 'quantity' => 18, 'added_price' => 0],
                ['color_id' => 3, 'variant_id' => 9, 'quantity' => 12, 'added_price' => 250],
                ['color_id' => 5, 'variant_id' => 10, 'quantity' => 8, 'added_price' => 520],
            ],
            'laptop' => [
                ['color_id' => 4, 'variant_id' => 7, 'quantity' => 10, 'added_price' => 0],
                ['color_id' => 5, 'variant_id' => 8, 'quantity' => 8, 'added_price' => 420],
                ['color_id' => 1, 'variant_id' => 9, 'quantity' => 5, 'added_price' => 780],
            ],
            'tv' => [
                ['color_id' => 1, 'variant_id' => 7, 'size_id' => 13, 'quantity' => 9, 'added_price' => 0],
                ['color_id' => 4, 'variant_id' => 8, 'size_id' => 14, 'quantity' => 7, 'added_price' => 650],
                ['color_id' => 5, 'variant_id' => 9, 'size_id' => 15, 'quantity' => 4, 'added_price' => 1400],
            ],
            'fridge' => [
                ['color_id' => 2, 'variant_id' => 7, 'quantity' => 7, 'added_price' => 0],
                ['color_id' => 4, 'variant_id' => 11, 'quantity' => 5, 'added_price' => 580],
                ['color_id' => 5, 'variant_id' => 12, 'quantity' => 3, 'added_price' => 960],
            ],
            'washer' => [
                ['color_id' => 2, 'variant_id' => 7, 'quantity' => 8, 'added_price' => 0],
                ['color_id' => 4, 'variant_id' => 11, 'quantity' => 6, 'added_price' => 440],
                ['color_id' => 5, 'variant_id' => 12, 'quantity' => 4, 'added_price' => 720],
            ],
            'ac' => [
                ['color_id' => 2, 'variant_id' => 11, 'size_id' => 16, 'quantity' => 8, 'added_price' => 0],
                ['color_id' => 4, 'variant_id' => 11, 'size_id' => 17, 'quantity' => 5, 'added_price' => 780],
                ['color_id' => 5, 'variant_id' => 12, 'size_id' => 17, 'quantity' => 3, 'added_price' => 1200],
            ],
            'headphone' => [
                ['color_id' => 1, 'variant_id' => 7, 'quantity' => 20, 'added_price' => 0],
                ['color_id' => 2, 'variant_id' => 8, 'quantity' => 14, 'added_price' => 90],
                ['color_id' => 3, 'variant_id' => 9, 'quantity' => 9, 'added_price' => 180],
            ],
            'smartwatch' => [
                ['color_id' => 1, 'variant_id' => 7, 'quantity' => 16, 'added_price' => 0],
                ['color_id' => 4, 'variant_id' => 8, 'quantity' => 11, 'added_price' => 130],
                ['color_id' => 6, 'variant_id' => 9, 'quantity' => 7, 'added_price' => 240],
            ],
            'camera' => [
                ['color_id' => 1, 'variant_id' => 7, 'quantity' => 9, 'added_price' => 0],
                ['color_id' => 5, 'variant_id' => 9, 'quantity' => 6, 'added_price' => 420],
                ['color_id' => 4, 'variant_id' => 12, 'quantity' => 4, 'added_price' => 760],
            ],
            'vacuum' => [
                ['color_id' => 2, 'variant_id' => 7, 'quantity' => 12, 'added_price' => 0],
                ['color_id' => 1, 'variant_id' => 11, 'quantity' => 8, 'added_price' => 230],
                ['color_id' => 5, 'variant_id' => 12, 'quantity' => 5, 'added_price' => 480],
            ],
        ];

        return array_map(function (array $variant) use ($price) {
            $attributes = [
                [
                    'attribute_id' => 1,
                    'value_id' => $variant['color_id'],
                ],
                [
                    'attribute_id' => 2,
                    'value_id' => $variant['variant_id'],
                ],
            ];

            if (isset($variant['size_id'])) {
                $attributes[] = [
                    'attribute_id' => 3,
                    'value_id' => $variant['size_id'],
                ];
            }

            return [
                'quantity' => $variant['quantity'],
                'added_price' => min($variant['added_price'], (int) round($price * 0.2)),
                'attributes' => json_encode($attributes, JSON_UNESCAPED_UNICODE),
            ];
        }, $profiles[$profile]);
    }
}
