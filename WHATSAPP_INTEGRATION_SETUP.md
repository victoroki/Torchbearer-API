# WhatsApp Integration with Ngumzo API - Setup Instructions

## Overview
This integration adds WhatsApp messaging capabilities to your Laravel application using the Ngumzo WhatsApp API. It includes contact management, single message sending, broadcasting to multiple contacts, and message history tracking.

## Laravel Version
This integration is built for **Laravel 10.x** (as detected in your composer.json)

## Files Created

### Backend Files

#### 1. Database Migrations
- `database/migrations/2025_10_27_190926_create_whatsapp_contacts_table.php`
- `database/migrations/2025_10_27_190935_create_whatsapp_messages_table.php`

#### 2. Models
- `app/Models/WhatsAppContact.php` - Manages WhatsApp contacts
- `app/Models/WhatsAppMessage.php` - Manages WhatsApp messages

#### 3. Service Class
- `app/Services/WhatsAppService.php` - Handles all Ngumzo API interactions
  - Send text messages
  - Send media messages (images, documents, videos, audio)
  - Check WhatsApp number registration
  - Check account balance

#### 4. Job Queue
- `app/Jobs/SendWhatsAppMessage.php` - Processes WhatsApp messages asynchronously

#### 5. Controller
- `app/Http/Controllers/WhatsAppController.php` - Handles all WhatsApp-related routes
  - Dashboard with statistics
  - Contact management (CRUD)
  - Send single messages
  - Broadcast to multiple contacts
  - Message history with filtering

### Frontend Files

#### Blade Views (located in `resources/views/communications/whatsapp/`)
1. **index.blade.php** - Dashboard with statistics and quick actions
2. **contacts.blade.php** - Contact management with add/edit/delete modals
3. **send.blade.php** - Send single message form
4. **broadcast.blade.php** - Broadcast message to multiple contacts
5. **history.blade.php** - Message history with filters and search

### Configuration Files
- **config/services.php** - Updated with Ngumzo API configuration
- **.env** - Updated with Ngumzo credentials

### Routes
- **routes/web.php** - Added WhatsApp routes under `/communications/whatsapp`

### Menu
- **resources/views/layouts/menu.blade.php** - Added WhatsApp menu item under Communications section

## Installation Steps

### 1. Database Setup
The migrations have already been run. The following tables were created:
- `whatsapp_contacts` - Stores WhatsApp contact information
- `whatsapp_messages` - Stores message history and status

### 2. Configure Ngumzo API Credentials

Edit your `.env` file and update the following values:

```env
# Ngumzo WhatsApp API Configuration
NGUMZO_API_KEY=your_actual_api_key_here
NGUMZO_BASE_URL=https://ngumzo.com/v1
NGUMZO_SENDER_PHONE=254712345678
```

**Important:**
- Replace `your_actual_api_key_here` with your actual Ngumzo API key
- Replace `254712345678` with your WhatsApp Business number (without +)
- Get your API key from: https://ngumzo.com/

### 3. Configure Queue for Broadcasting

For the broadcasting feature to work properly, you need to configure Laravel's queue system.

#### Option A: Database Queue (Recommended for Production)

1. Update `.env`:
```env
QUEUE_CONNECTION=database
```

2. Create the jobs table:
```bash
php artisan queue:table
php artisan migrate
```

3. Run the queue worker:
```bash
php artisan queue:work
```

#### Option B: Sync Queue (Development Only)
Keep the current setting in `.env`:
```env
QUEUE_CONNECTION=sync
```

Messages will be sent synchronously (slower for broadcasting).

### 4. Clear Configuration Cache
```bash
php artisan config:clear
php artisan cache:clear
```

## Features

### 1. Contact Management
**Location:** Communications → WhatsApp → Contacts

- Add new contacts with name, phone number, email, group, and notes
- Edit existing contacts
- Delete contacts
- Organize contacts by groups
- Active/Inactive status management

**Phone Number Format:** Use international format without + (e.g., 254712345678 for Kenya)

### 2. Send Single Message
**Location:** Communications → WhatsApp → Send Message

- Send to existing contacts or manual entry
- Support for text messages
- Optional media attachments (images, documents, videos, audio)
- Media caption support
- Character counter
- Real-time validation

### 3. Broadcast Messages
**Location:** Communications → WhatsApp → Broadcast

Features:
- Select multiple contacts using checkboxes
- Filter and select by group
- Select All / Deselect All functionality
- Group selection buttons
- Shows selected contact count
- Support for media attachments
- Confirmation before sending
- Progress tracking

**How it works:**
- Messages are queued for each selected contact
- Each contact receives an individual message
- Messages are sent asynchronously via Laravel Queue
- Status tracking for each message

### 4. Message History
**Location:** Communications → WhatsApp → History

Features:
- View all sent messages
- Filter by status (Pending, Sent, Failed, Delivered)
- Date range filtering
- Search by name, phone, or message content
- View detailed message information
- Error message display for failed messages
- Media attachment information

### 5. Dashboard
**Location:** Communications → WhatsApp

Displays:
- Total active contacts
- Total messages sent
- Total messages
- Failed messages count
- Recent messages (last 10)
- Quick action buttons

## API Endpoints Used

### 1. Send Text Message
```
POST https://ngumzo.com/v1/send-message
```
Headers:
- `Content-Type: application/json`
- `api-key: YOUR_API_KEY`

Body:
```json
{
  "sender": "254712345678",
  "recipient": "254722334455",
  "message": "Your message here"
}
```

### 2. Send Media Message
```
POST https://ngumzo.com/v1/send-message
```
Body includes additional fields:
```json
{
  "sender": "254712345678",
  "recipient": "254722334455",
  "message": "Your message here",
  "media_type": "image|document|video|audio",
  "url": "https://example.com/file.jpg",
  "caption": "Optional caption"
}
```

### 3. Check Number
```
POST https://ngumzo.com/v1/check-number
```
Verify if a number is registered on WhatsApp.

### 4. Check Balance
```
POST https://ngumzo.com/v1/check-balance
```
Check your Ngumzo credits balance.

## Usage Examples

### Adding Contacts
1. Go to Communications → WhatsApp → Contacts
2. Click "Add Contact"
3. Fill in the form (name and phone are required)
4. Phone format: 254712345678 (no + symbol)
5. Click "Save Contact"

### Sending a Single Message
1. Go to Communications → WhatsApp → Send Message
2. Choose recipient type:
   - From Contacts: Select from dropdown
   - Manual Entry: Enter phone and name
3. Type your message
4. (Optional) Check "Include Media" and provide:
   - Media type (image, document, video, audio)
   - Media URL (must be publicly accessible)
   - Caption (optional)
5. Click "Send Message"

### Broadcasting Messages
1. Go to Communications → WhatsApp → Broadcast
2. Select recipients:
   - Use checkboxes to select individual contacts
   - Use "Select All" for all contacts
   - Use group buttons to select by group
3. Type your message
4. (Optional) Add media attachment
5. Click "Broadcast Message"
6. Confirm the number of recipients
7. Messages will be queued and sent

### Viewing Message History
1. Go to Communications → WhatsApp → History
2. Use filters:
   - Status filter (All, Pending, Sent, Failed, Delivered)
   - Date range (From/To)
   - Search (by name, phone, or message content)
3. Click "Apply Filters"
4. Click the eye icon to view detailed message information

## Database Schema

### whatsapp_contacts
```sql
- id (primary key)
- name (string)
- phone_number (string, unique)
- email (string, nullable)
- notes (text, nullable)
- group (string, nullable)
- is_active (boolean, default: true)
- created_at, updated_at (timestamps)
```

### whatsapp_messages
```sql
- id (primary key)
- contact_id (foreign key, nullable)
- recipient_phone (string)
- recipient_name (string, nullable)
- message (text)
- media_type (string, nullable)
- media_url (string, nullable)
- media_caption (text, nullable)
- status (enum: pending, sent, failed, delivered)
- error_message (text, nullable)
- sent_at (timestamp, nullable)
- user_id (foreign key)
- created_at, updated_at (timestamps)
```

## Troubleshooting

### Messages Stuck in "Pending" Status
**Cause:** Queue worker not running
**Solution:** Start the queue worker:
```bash
php artisan queue:work
```

### "Failed to send message" Errors
**Possible causes:**
1. Invalid API key → Check `.env` file
2. Invalid phone number format → Use format: 254712345678
3. Insufficient credits → Check balance via API
4. Network issues → Check internet connectivity

### Media Messages Not Sending
**Possible causes:**
1. Media URL not publicly accessible
2. Unsupported media type
3. File too large
**Solution:** Ensure media URL is:
- Publicly accessible (no authentication required)
- Valid HTTPS URL
- Correct media type (image, document, video, audio)

### Foreign Key Constraint Errors
**Solution:** Ensure migrations run in order:
```bash
php artisan migrate:fresh
```

## Queue Management

### Start Queue Worker (Production)
```bash
php artisan queue:work --daemon
```

### View Failed Jobs
```bash
php artisan queue:failed
```

### Retry Failed Jobs
```bash
php artisan queue:retry all
```

### Monitor Queue
```bash
php artisan queue:work --verbose
```

## Security Considerations

1. **API Key Protection**
   - Never commit `.env` file to version control
   - Keep API key confidential
   - Rotate API key periodically

2. **Phone Number Validation**
   - Always validate phone numbers before sending
   - Use Ngumzo's check-number endpoint

3. **Rate Limiting**
   - Implement rate limiting for broadcast feature
   - Monitor API usage to avoid hitting limits

4. **User Permissions**
   - Consider adding authorization policies
   - Restrict access to WhatsApp features based on user roles

## Available Routes

```
GET  /communications/whatsapp                    - Dashboard
GET  /communications/whatsapp/contacts           - Contact list
POST /communications/whatsapp/contacts           - Store contact
PUT  /communications/whatsapp/contacts/{id}      - Update contact
DELETE /communications/whatsapp/contacts/{id}    - Delete contact
GET  /communications/whatsapp/send               - Send message form
POST /communications/whatsapp/send               - Send message
GET  /communications/whatsapp/broadcast          - Broadcast form
POST /communications/whatsapp/broadcast          - Send broadcast
GET  /communications/whatsapp/history            - Message history
GET  /communications/whatsapp/balance            - Check balance (API)
```

All routes are protected by the `auth` middleware.

## Support & Resources

- **Ngumzo Documentation:** https://ngumzo.com/documentation
- **Ngumzo Dashboard:** https://ngumzo.com/ (to get API key and manage account)
- **Laravel Queue Documentation:** https://laravel.com/docs/10.x/queues

## Next Steps

1. **Get your Ngumzo API credentials:**
   - Sign up at https://ngumzo.com/
   - Get your API key from the dashboard
   - Note your WhatsApp Business number

2. **Update .env file** with your credentials

3. **Configure queue system** for broadcasting

4. **Add some test contacts**

5. **Send test messages**

6. **Set up queue worker** for production

## Credits & Author

Integration created for Torchbearer Laravel Application
API Provider: Ngumzo (https://ngumzo.com/)
Laravel Version: 10.x

---

## Quick Start Checklist

- [x] Migrations created and run
- [x] Models created (WhatsAppContact, WhatsAppMessage)
- [x] Service class created (WhatsAppService)
- [x] Controller created (WhatsAppController)
- [x] Job created (SendWhatsAppMessage)
- [x] Routes added
- [x] Views created (5 blade files)
- [x] Menu updated
- [ ] Get Ngumzo API key from https://ngumzo.com/
- [ ] Update .env with API credentials
- [ ] Configure queue system
- [ ] Start queue worker
- [ ] Clear cache
- [ ] Test with sample message

---

Happy messaging! 🎉
