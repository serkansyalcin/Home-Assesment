# Ideasoft Take-Home Projesi - RESTful API

Bu proje, Ideasoft tarafından verilen take-home görevinin bir çözümüdür. Sipariş yönetimi ve indirim hesaplamaları için RESTful API servisleri içerir.

## Teknolojiler

- PHP 8.2
- Laravel Framework 12.x
- MySQL
- Docker

## Kurulum

### Docker ile Kurulum

1. Projeyi klonlayın:
   ```bash
   git clone https://github.com/serkansyalcin/Home-Assesment.git
   cd Home-Assesment
   ```

2. `.env.example` dosyasını `.env` olarak kopyalayın:
   ```bash
   cp .env.example .env
   ```

3. Docker konteynerlerini başlatın:
   ```bash
   docker-compose up -d
   ```

4. Uygulama konteynerine bağlanın:
   ```bash
   docker-compose exec app bash
   ```

5. Composer bağımlılıklarını yükleyin:
   ```bash
   composer install
   ```

6. Uygulama anahtarını oluşturun:
   ```bash
   php artisan key:generate
   ```

7. Veritabanı migrasyonlarını ve seed'leri çalıştırın:
   ```bash
   php artisan migrate --seed
   ```

Uygulama şimdi http://localhost:8000 adresinde çalışıyor olmalıdır.

## API Endpoint'leri

### Siparişler (Görev 1)

| Metod | Endpoint | Açıklama |
|-------|----------|----------|
| GET | /api/orders | Tüm siparişleri listele |
| GET | /api/orders/{id} | Belirli bir siparişi göster |
| POST | /api/orders | Yeni sipariş oluştur |
| DELETE | /api/orders/{id} | Siparişi sil |

#### Sipariş Oluşturma İsteği Örneği

```bash
curl -X POST http://localhost:8000/api/orders \
  -H "Content-Type: application/json" \
  -d '{"customer_id": 1, "total_price": 1500}'
```

POST /api/orders
{
"customer_id": 1,
"items": [
{
"product_id": 102,
"quantity": 10
},
{
"product_id": 101,
"quantity": 2
}
]
}
```

### İndirim Hesaplamaları (Görev 2)

| Metod | Endpoint | Açıklama |
|-------|----------|----------|
| GET | /api/discounts | Tüm indirimleri listele |
| GET | /api/discounts/{id} | Belirli bir indirimi göster |

#### İndirim Hesaplaması Örneği

json
{
"orderId": 1,
"discounts": [
{
"discountReason": "10_PERCENT_OVER_1000",
"amount": 149.7
},
{
"discountReason": "BUY_6_GET_1_FREE_CATEGORY_2",
"amount": 59.9
}
],
"totalDiscount": 209.6,
"discountedTotal": 1287.4
}
```

## İndirim Kuralları

Projede üç farklı indirim kuralı uygulanmaktadır:

1. **Toplam Tutar İndirimi**: Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, siparişin tamamından %10 indirim kazanır.
2. **Kategori 2 - 6 Al 1 Bedava**: 2 ID'li kategoriye ait bir üründen 6 adet satın alındığında, bir tanesi ücretsiz olarak verilir.
3. **Kategori 1 - En Ucuza İndirim**: 1 ID'li kategoriden iki veya daha fazla ürün satın alındığında, en ucuz ürüne %20 indirim yapılır.

## Proje Yapısı

Proje, aşağıdaki ana bileşenlerden oluşmaktadır:

- **Model Sınıfları**: `Customer`, `Product`, `Category`, `Order`, `OrderItem`
- **Controller Sınıfları**: `OrderController`, `DiscountController`
- **Servis Sınıfları**: `OrderService`, `DiscountService`
- **İndirim Stratejileri**: `TotalPriceDiscount`, `CategoryTwoSixPlusOneDiscount`, `CategoryOneCheapestDiscount`



