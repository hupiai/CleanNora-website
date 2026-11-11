# CleanNora Website

Production website source for CleanNora home services.

Current build includes:
- Mobile-responsive service discovery and booking flow
- Instant Maid, Instant Cook, Instant Plumber, Beautician at Home, House Cleaning, Toilet Cleaning and Car Cleaning
- Sector-wise SEO coverage for Noida, Greater Noida, Gaur City / Greater Noida West and Indirapuram
- Become a Partner application flow
- Official customer contact number: +91 92050 80012
- Sitemap, robots and LocalBusiness structured data

Security note: production database credentials are intentionally not stored in this public repository. Configure `includes/db.php` on the production server using secure environment/server credentials.

## Customer Care Bookings

The internal panel lives at `/staff/manual-bookings.php`. Agents can enter a phone,
WhatsApp or website callback booking, record the final quote, confirm after checking
availability, assign a partner manually, reschedule, cancel or mark the visit
complete. Rescheduling returns the booking to pending and clears the assignment.
The WhatsApp action opens a prefilled message for the agent to review and send.

### Set up on staging

1. Use PHP 8.1+ with mysqli and mysqlnd, the existing server-side Firebase
   Admin SDK, and HTTPS. Serve the existing web Firebase config at
   `/assets/js/firebase-config.js` and enable Firebase email/password sign-in.
   Ensure PHP receives the Authorization header on requests to the staff API.
2. Apply `migrations/001_manual_bookings.sql` to the MySQL database configured
   by `includes/db.php`. Keep migration files outside the web root. The application
   database user needs SELECT, INSERT and UPDATE on the new table.
3. Create individual Firebase Auth accounts for customer-care staff. Set the
   boolean custom claim `customerCare` to `true` through a trusted Admin SDK
   environment, preserving existing custom claims. Staff must sign in again
   after a claim change. Revoke refresh tokens when removing access.
4. Verify unauthenticated and customer accounts cannot read or write bookings.
   With a staff account and synthetic customer details, test creating, finding,
   confirming, assigning and rescheduling a booking before rollout.

The manual queue uses MySQL so agents can handle bookings for callers without a
Firebase customer account. The `CN-M-` references identify staff-managed records.
The queue does not check live availability, trigger partner dispatch, create
app bookings, accept payments, send OTPs or feed the public tracker. Staff check
availability, contact partners and communicate updates outside this panel.
