# สร้างโครงสร้าง Package

*สร้าง Repository คำสั่ง ดังนี้:*

```
php artisan make:repository [NameRepository]
```

### 🚀 ตัวอย่างคำสั่งที่ใช้งาน

| คำสั่ง                                                                                       |                          ผลลัพธ์                          | 
|:---------------------------------------------------------------------------------------------|:---------------------------------------------------------:|
| `php artisan make:repository UserRepository `                                                |                 **สร้าง Repository ปกติ**                 |
| `php artisan make:repository UserRepository --empty `                                        |     สร้าง Repository ว่าง (ไม่มีฟังก์ชัน) แต่มี Model     |
| `php artisan make:repository UserRepository --test --model=Admin`                                                                                             |                             สร้าง Repository `UserRepository` ที่ใช้ Model `Admin` และมี Test                              |
|`php artisan make:repository UserRepository --path=app/Services`|สร้าง Repository ใน `app/Services/`|
|`php artisan make:repository UserRepository --test`|สร้าง Repository พร้อม Pest Test|

### สรุป

* ✅ เพิ่ม option --empty เพื่อสร้างไฟล์ Repository เปล่า
* ✅ ไฟล์เปล่ายังคงมี __construct() และ Model
* ✅ สามารถกำหนด Model เองผ่าน --model=[User] (ชื่อ Modal จะขึ้นต้นด้วยตัวพิมพ์ใหญ่)
* ✅ ถ้าไม่กำหนด --model จะใช้ชื่อ Repository แล้วตัด "Repository" ออกเป็น Model