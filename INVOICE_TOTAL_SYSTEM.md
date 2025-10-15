# نظام حساب PR Invoices Total Value التلقائي

## 📋 نظرة عامة

تم تطوير نظام **حساب تلقائي** لمجموع قيم الفواتير المرتبطة بنفس رقم المشروع (PR_NUMBER).

---

## ⚙️ كيف يعمل النظام

### 1. عند **إضافة** فاتورة جديدة (`store`)
```php
// يحسب مجموع جميع الفواتير السابقة لنفس PR_NUMBER
$existingTotal = invoices::where('pr_number', $data['pr_number'])->sum('value');

// يضيف قيمة الفاتورة الجديدة
$data['pr_invoices_total_value'] = $existingTotal + $data['value'];

// بعد الحفظ، يحدث جميع الفواتير المرتبطة بنفس PR_NUMBER
$newTotal = invoices::where('pr_number', $data['pr_number'])->sum('value');
invoices::where('pr_number', $data['pr_number'])
    ->update(['pr_invoices_total_value' => $newTotal]);
```

### 2. عند **تعديل** فاتورة (`update`)
```php
// يحفظ رقم المشروع القديم (في حالة تغيير PR_NUMBER)
$oldPrNumber = $invoices->pr_number;

// بعد التحديث، يعيد حساب المجموع للمشروع الجديد
$newTotal = invoices::where('pr_number', $data['pr_number'])->sum('value');
invoices::where('pr_number', $data['pr_number'])
    ->update(['pr_invoices_total_value' => $newTotal]);

// إذا تغير PR_NUMBER، يعيد حساب المجموع للمشروع القديم أيضاً
if ($oldPrNumber != $data['pr_number']) {
    $oldTotal = invoices::where('pr_number', $oldPrNumber)->sum('value');
    invoices::where('pr_number', $oldPrNumber)
        ->update(['pr_invoices_total_value' => $oldTotal]);
}
```

### 3. عند **حذف** فاتورة (`destroy`)
```php
// يحفظ رقم المشروع قبل الحذف
$prNumber = $invoice->pr_number;

// بعد الحذف، يعيد حساب المجموع للفواتير المتبقية
$newTotal = invoices::where('pr_number', $prNumber)->sum('value');
invoices::where('pr_number', $prNumber)
    ->update(['pr_invoices_total_value' => $newTotal]);
```

---

## 📊 مثال عملي

### السيناريو:
لديك مشروع **PR #1 - mazen sabry**

#### الخطوة 1: إضافة أول فاتورة
- Invoice #7: Value = **5,000**
- النتيجة: `pr_invoices_total_value` = **5,000**

#### الخطوة 2: إضافة فاتورة ثانية
- Invoice #645: Value = **456,456**
- النتيجة: 
  - Invoice #7: `pr_invoices_total_value` = **461,456** (5,000 + 456,456)
  - Invoice #645: `pr_invoices_total_value` = **461,456**

#### الخطوة 3: إضافة فاتورة ثالثة
- Invoice #999: Value = **10,000**
- النتيجة:
  - **جميع الفواتير** الثلاثة: `pr_invoices_total_value` = **471,456** (5,000 + 456,456 + 10,000)

#### الخطوة 4: حذف فاتورة
- حذف Invoice #999 (Value = 10,000)
- النتيجة:
  - Invoice #7: `pr_invoices_total_value` = **461,456**
  - Invoice #645: `pr_invoices_total_value` = **461,456**

---

## ✅ الميزات

1. **حساب تلقائي 100%**: لا حاجة لإدخال يدوي
2. **تحديث فوري**: جميع الفواتير المرتبطة تُحدث تلقائياً
3. **دعم تغيير PR_NUMBER**: عند نقل فاتورة لمشروع آخر، يُعاد حساب المجموع للمشروعين
4. **دقة عالية**: استخدام `sum()` من قاعدة البيانات مباشرة
5. **مسح Cache تلقائي**: لضمان ظهور البيانات المحدثة فوراً

---

## 🔍 الاختبار

تم إنشاء سكريبتين للاختبار:

### 1. `test_invoice_total.php`
- يختبر صحة الحسابات
- يعرض حالة جميع الفواتير
- يتحقق من تطابق القيم

### 2. `fix_invoice_totals.php`
- يصلح الفواتير القديمة (الموجودة قبل التطوير)
- يحدث `pr_invoices_total_value` لجميع الفواتير
- تم تشغيله مرة واحدة وحدّث **5 فواتير** بنجاح ✅

---

## 📁 الملفات المعدلة

### Controller
- `app/Http/Controllers/InvoicesController.php`
  - ✅ `store()` - إضافة فاتورة
  - ✅ `update()` - تعديل فاتورة  
  - ✅ `destroy()` - حذف فاتورة

### Model
- `app/Models/invoices.php`
  - الحقل `pr_invoices_total_value` موجود في `$fillable`

---

## 🎯 النتيجة النهائية

```
✅ جميع الفواتير المرتبطة بنفس PR_NUMBER لها نفس قيمة المجموع
✅ التحديث تلقائي عند: إضافة / تعديل / حذف
✅ دعم تغيير PR_NUMBER
✅ تم اختبار النظام بنجاح
✅ 5 فواتير موجودة تم تحديثها بنجاح
```

---

## 🔧 الصيانة

إذا احتجت لإعادة حساب جميع القيم في المستقبل:
```bash
php fix_invoice_totals.php
```

---

## 📞 ملاحظات

- النظام يعمل **تلقائياً** - لا حاجة لأي إجراء يدوي
- جميع العمليات **آمنة** ومحمية بـ validation
- الـ **Cache يُمسح تلقائياً** بعد كل عملية
- النظام يدعم **unlimited invoices** لنفس المشروع

---

**تم التطوير والاختبار بنجاح** ✅
**التاريخ:** 15 أكتوبر 2025
