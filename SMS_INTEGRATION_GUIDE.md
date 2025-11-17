# SMS Integration Guide - Roberms API

## 🎉 Complete SMS System Implemented!

Your Laravel system now has a full-featured SMS integration with the Roberms API.

---

## 📋 What's Been Created

### 1. **Database Tables** ✅
- `sms_logs` - Track all sent SMS messages
- `sms_preferences` - Customer SMS preferences (opt-in/opt-out)
- `scheduled_sms` - Schedule SMS campaigns for future sending

### 2. **Models** ✅
- `SmsLog` - SMS history with relationships
- `SmsPreference` - Customer preferences management
- `ScheduledSms` - Scheduled SMS campaigns

### 3. **Service Layer** ✅
- `app/Services/RobermsSmsService.php`
  - Send single SMS
  - Send bulk SMS
  - Check credit balance
  - Phone number formatting (0712..., 712..., 254712...)
  - Token caching (50 minutes)

### 4. **Notification System** ✅
- `app/Notifications/Channels/SmsChannel.php` - Custom SMS channel
- `app/Notifications/CarpetReceivedSms.php` - Carpet confirmation
- `app/Notifications/ReadyForPickupSms.php` - Ready notification
- `app/Notifications/PaymentReminderSms.php` - Payment reminders

### 5. **Controller** ✅
- `app/Http/Controllers/Backend/SmsController.php`
  - Dashboard
  - Send single SMS
  - Send bulk SMS
  - Preview recipients
  - Get balance

### 6. **Views (Admin Panel)** ✅
- `/sms/dashboard` - Beautiful SMS dashboard with stats
- `/sms/send` - Send single SMS form
- `/sms/bulk` - Send bulk SMS with filters

### 7. **Configuration** ✅
- `config/sms.php` - SMS configuration with 10+ templates
- `.env.example` - Updated with SMS variables

### 8. **Routes** ✅
All SMS routes registered in `routes/web.php`

---

## 🚀 Setup Instructions

### Step 1: Add Your Roberms Credentials

Edit your `.env` file and add:

```env
# Roberms SMS Configuration
ROBERMS_BASE_URL=https://roberms.co.ke/sms/v1/roberms
ROBERMS_CONSUMER_KEY=your_actual_consumer_key_here
ROBERMS_CONSUMER_PASSWORD=your_actual_password_here
ROBERMS_SENDER_NAME=RAHA

# Optional: Enable automated SMS
SMS_AUTO_CARPET_RECEIVED=false
SMS_AUTO_LAUNDRY_RECEIVED=false
SMS_AUTO_READY_PICKUP=false
SMS_AUTO_PAYMENT_REMINDERS=false

# Business Info
BUSINESS_NAME="Raha Carpet & Laundry"
BUSINESS_PHONE=0712345678
BUSINESS_LOCATION=Nairobi
```

### Step 2: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### Step 3: Access the SMS Dashboard

Visit: `http://your-domain.com/sms/dashboard`

---

## 💬 Pre-Built Message Templates

Located in `config/sms.php`:

1. **welcome** - New customer greeting
2. **carpet_received** - Carpet order confirmation
3. **laundry_received** - Laundry order confirmation
4. **ready_for_pickup** - Item ready for collection
5. **payment_reminder** - Unpaid balance reminder
6. **overdue_reminder** - Long overdue items
7. **thank_you** - Post-delivery appreciation
8. **promotional** - Special offers
9. **birthday** - Birthday wishes with discount
10. **inactive_customer** - Win-back campaign

### Template Variables

Templates use placeholders like `:name`, `:uniqueid`, `:amount`, etc.
These are automatically replaced when sending SMS.

---

## 🎯 How to Use

### A. Manual SMS (Via Admin Panel)

**1. Access SMS Dashboard:**
- Go to `/sms/dashboard`
- View SMS balance, customer count, available templates

**2. Send Single SMS:**
- Go to `/sms/send`
- Enter phone number (any format)
- Select template or type custom message
- Send!

**3. Send Bulk SMS:**
- Go to `/sms/bulk`
- Choose recipient filter:
  - All carpet customers
  - All laundry customers
  - Unpaid orders
  - Ready for pickup
  - Inactive customers (60+ days)
- Preview recipients
- Write message
- Confirm and send!

### B. Programmatic Usage

**Send SMS from Code:**

```php
use App\Services\RobermsSmsService;

$smsService = app(RobermsSmsService::class);

// Send single SMS
$result = $smsService->sendSms('0712345678', 'Your message here');

if ($result['success']) {
    // SMS sent successfully
} else {
    // Handle error: $result['message']
}

// Send bulk SMS
$phones = ['0712345678', '0722334455', '0733445566'];
$result = $smsService->sendBulkSms($phones, 'Bulk message');

// Check balance
$balance = $smsService->getCreditBalance();
echo "Balance: " . $balance['balance'];
```

**Using Notifications:**

```php
use App\Notifications\CarpetReceivedSms;

$carpet = Carpet::find(1);

// Create a notifiable object (needs 'phone' property)
$customer = (object)['phone' => $carpet->phone];

// Send notification
$customer->notify(new CarpetReceivedSms($carpet));
```

### C. Auto-Send on Events

To automatically send SMS when creating orders, add this to your controllers:

**CarpetController.php - StoreCarpet():**

```php
use App\Notifications\CarpetReceivedSms;

// After creating carpet
if (config('sms.auto_send.on_carpet_received')) {
    $customer = (object)['phone' => $carpet->phone];
    $customer->notify(new CarpetReceivedSms($carpet));
}
```

**LaundryController.php - StoreLaundry():**

```php
use App\Notifications\ReadyForPickupSms;

// When marking as ready
if ($laundry->delivered === 'Delivered' && config('sms.auto_send.on_ready_for_pickup')) {
    $customer = (object)['phone' => $laundry->phone];
    $customer->notify(new ReadyForPickupSms($laundry, 'laundry'));
}
```

---

## 📊 Features

✅ **Phone Number Formatting** - Auto-converts all formats to 254...
✅ **Token Caching** - API token cached for 50 minutes
✅ **Bulk Sending** - Send to hundreds with one click
✅ **Template System** - 10+ pre-built professional templates
✅ **Balance Checking** - Real-time SMS credit balance
✅ **Error Logging** - All API errors logged to Laravel log
✅ **Queue Support** - Notifications can be queued (set `ShouldQueue`)
✅ **Custom Filters** - Target specific customer segments
✅ **SMS History** - Track all sent messages (database logging)
✅ **Customer Preferences** - Opt-in/opt-out system (ready)
✅ **Scheduled Campaigns** - Schedule for future sending (ready)

---

## 🔄 SMS Logging

Every SMS sent is automatically logged to `sms_logs` table with:
- Phone number
- Message content
- Status (sent/failed)
- Type (manual/automated/bulk)
- Timestamp
- Related model (Carpet/Laundry)
- Error messages (if failed)

**Query SMS History:**

```php
use App\Models\SmsLog;

// Get all sent SMS
$sentSms = SmsLog::sent()->get();

// Get failed SMS
$failedSms = SmsLog::failed()->get();

// Get SMS for specific phone
$customerSms = SmsLog::where('phone_number', '254712345678')->get();

// Get today's SMS
$todaySms = SmsLog::whereDate('created_at', today())->get();
```

---

## 📈 Bulk SMS Filters

Available in `/sms/bulk`:

| Filter | Description |
|--------|-------------|
| `all_carpets` | All customers who used carpet service |
| `all_laundry` | All customers who used laundry service |
| `unpaid_carpets` | Carpet orders with pending payment |
| `unpaid_laundry` | Laundry orders with pending payment |
| `ready_carpets` | Carpets ready for pickup |
| `ready_laundry` | Laundry ready for pickup |
| `inactive_customers` | No orders in 60+ days |

---

## 🎨 Customization

### Add New Message Template

Edit `config/sms.php`:

```php
'templates' => [
    // ... existing templates

    'custom_template' => 'Hello :name, your custom message here. Call :phone',
],
```

### Add New Bulk Filter

Edit `app/Http/Controllers/Backend/SmsController.php` in `getRecipientsByFilter()` method:

```php
case 'your_filter_name':
    $recipients = Carpet::where('your_condition', 'value')
        ->select('phone', 'name')
        ->distinct('phone')
        ->get()
        ->toArray();
    break;
```

### Customize SMS Sender Name

Change in `.env`:

```env
ROBERMS_SENDER_NAME=YourBrand
```

---

## 🛠️ Troubleshooting

### Issue: SMS Not Sending

**Check:**
1. Credentials in `.env` are correct
2. SMS balance is sufficient (check dashboard)
3. Phone number format is valid
4. Check `storage/logs/laravel.log` for errors

**Test:**

```bash
php artisan tinker
>>> app(\App\Services\RobermsSmsService::class)->sendSms('254712345678', 'Test message')
```

### Issue: Invalid Phone Number

**Solution:**
Phone formatting supports:
- `0712345678` ✅
- `712345678` ✅
- `254712345678` ✅
- `+254712345678` ❌ (remove +)

### Issue: Access Token Failed

**Check:**
- Internet connection
- Roberms API is accessible
- Consumer key and password are correct
- Cache cleared: `php artisan cache:clear`

---

## 📱 SMS Pricing Guide

**Standard SMS:**
- 1-160 characters = 1 SMS credit
- 161-320 characters = 2 SMS credits
- 321-480 characters = 3 SMS credits

**Best Practices:**
- Keep messages under 160 characters
- Avoid special characters (they count as 2)
- Include business name
- Add call-to-action
- Send at appropriate times (9am-8pm)

---

## 🔒 Security Best Practices

1. **Never commit `.env` file** - Contains API credentials
2. **Use HTTPS** - Protect API tokens in transit
3. **Validate phone numbers** - Prevent SMS to invalid numbers
4. **Respect opt-outs** - Check SMS preferences before sending
5. **Rate limiting** - Avoid spamming customers

---

## 📞 Support & Documentation

**Roberms API Docs:**
- https://roberms.co.ke/documentation

**Get Credentials:**
- Register at: https://roberms.co.ke
- Navigate to API settings
- Copy consumer key and password

**Need Help?**
- Check Laravel logs: `storage/logs/laravel.log`
- Test API credentials in Tinker
- Contact Roberms support for API issues

---

## 🎉 You're All Set!

Your SMS system is fully integrated and ready to use. Just add your Roberms credentials and start sending messages!

**Next Steps:**
1. Add Roberms credentials to `.env`
2. Clear cache
3. Visit `/sms/dashboard`
4. Send your first test SMS
5. Configure automated SMS if needed

---

**Created with ❤️ using Roberms SMS API**

