# SEO Implementation Guide
## MahoneT HR Consulting

This guide will help you optimize your website to rank on Google when people search for "HR consulting" and related terms.

---

## Table of Contents
1. [Understanding SEO](#understanding-seo)
2. [On-Page SEO (Technical Changes)](#on-page-seo)
3. [Google Search Console Setup](#google-search-console-setup)
4. [Google Business Profile](#google-business-profile)
5. [Content Strategy](#content-strategy)
6. [Local SEO](#local-seo)
7. [Link Building](#link-building)
8. [Ongoing SEO Maintenance](#ongoing-seo-maintenance)

---

## Understanding SEO

### How Long Does SEO Take?
- **Timeline:** 3-6 months to see significant results
- **Why:** Google needs time to crawl, index, and rank your site
- **Realistic Expectations:**
  - Month 1-2: Google discovers your site
  - Month 3-4: You start appearing on page 2-3 for some keywords
  - Month 6+: You can reach page 1 for specific/local searches

### Keywords You Should Target

**Primary Keywords (High Competition):**
- "HR consulting" - Very competitive
- "HR consultant" - Very competitive
- "Human resources consulting" - Competitive

**Secondary Keywords (More Realistic):**
- "HR consulting for small business"
- "HR compliance consulting"
- "HR consultant near me" (if you have local presence)
- "Employee relations consultant"
- "HR policy development"
- "Behavioral health HR consulting"

**Long-Tail Keywords (Best Starting Point):**
- "HR consultant for behavioral health agencies"
- "HR compliance for small business Maryland" (add your location)
- "Employee handbook development services"
- "HR audit and compliance services"
- "Leadership coaching for small business owners"

---

## On-Page SEO (Technical Changes)

I've updated your website files with the following SEO improvements:

### 1. Meta Tags Added to All Pages
Each page now includes:
- **Title Tag:** Unique, keyword-rich titles (50-60 characters)
- **Meta Description:** Compelling descriptions (150-160 characters)
- **Open Graph Tags:** For social media sharing
- **Keywords Meta:** Relevant keywords for each page
- **Canonical URLs:** Prevent duplicate content issues

### 2. Structured Data (Schema Markup)
Added JSON-LD structured data for:
- **Organization Schema:** Company info, contact details
- **Local Business Schema:** If you have a physical location
- **Professional Service Schema:** HR consulting services
- **Breadcrumbs:** Navigation structure

### 3. Sitemap.xml Created
- Lists all pages on your website
- Helps Google crawl and index your site faster
- Located at: `https://mahonetconsulting.com/sitemap.xml`

### 4. Robots.txt Created
- Tells search engines which pages to crawl
- Located at: `https://mahonetconsulting.com/robots.txt`

### 5. Semantic HTML Improvements
- Proper heading hierarchy (H1 → H2 → H3)
- Alt text for all images
- Descriptive link text (no "click here")

---

## Google Search Console Setup

**This is CRITICAL - do this first!**

### Step 1: Create Google Search Console Account

1. **Go to:** https://search.google.com/search-console
2. **Sign in** with your Google account (or create one)
3. **Click "Add Property"**
4. **Choose "URL prefix"**
5. **Enter:** `https://mahonetconsulting.com`

### Step 2: Verify Website Ownership

You'll need to prove you own the site. Choose one method:

**Method 1: HTML File Upload (Easiest)**
1. Google will give you an HTML file to download (e.g., `google1234567890abcdef.html`)
2. Upload this file to your `public_html` folder in cPanel
3. Go back to Google Search Console and click "Verify"

**Method 2: HTML Tag (Also Easy)**
1. Google will give you a meta tag like:
   ```html
   <meta name="google-site-verification" content="ABC123XYZ..." />
   ```
2. Add this tag to the `<head>` section of your `index.html`
3. Upload the updated file
4. Go back to Google Search Console and click "Verify"

**Method 3: DNS Record (More Technical)**
1. Google will give you a TXT record
2. Add it to your domain's DNS settings in GreenGeeks
3. Wait 24-48 hours for DNS propagation
4. Click "Verify" in Google Search Console

### Step 3: Submit Your Sitemap

1. In Google Search Console, go to **Sitemaps** (left menu)
2. Enter: `sitemap.xml`
3. Click **Submit**
4. Google will start crawling your site within days

### Step 4: Monitor Your Site

Check Google Search Console weekly to see:
- **Performance:** Which keywords bring traffic
- **Coverage:** Which pages are indexed
- **Enhancements:** Any issues to fix
- **Links:** Who's linking to your site

---

## Google Business Profile

**Important:** Only if you have a physical office or serve local customers.

### Step 1: Create/Claim Your Business Profile

1. **Go to:** https://www.google.com/business
2. **Click "Manage now"**
3. **Enter business name:** MahoneT HR Consulting
4. **Select category:** Human Resources Consulting
5. **Add location:**
   - If you have an office: Enter physical address
   - If home-based/remote: Choose "I deliver goods and services to my customers"

### Step 2: Complete Your Profile

**Essential Information:**
- Business name: MahoneT HR Consulting
- Category: Human Resources Consulting
- Service area: List cities/states you serve
- Phone: Your business phone
- Website: https://mahonetconsulting.com
- Hours: Business hours
- Description: 750 characters describing your HR consulting services

**Add Photos:**
- Logo
- Office photos (if applicable)
- Team photos
- Service images

**Services:** List all your HR consulting services:
- HR Compliance & Audits
- Recruiting & Talent Acquisition
- Policy & Employee Handbooks
- Employee Relations
- Leadership Coaching & Training

### Step 3: Get Reviews

Google reviews are CRUCIAL for local SEO:
1. **Ask satisfied clients** for reviews
2. **Send them direct link** to your Google review page
3. **Respond to all reviews** (good and bad)
4. **Aim for 10+ reviews** in first 3 months

---

## Content Strategy

To rank for "HR consulting," you need MORE content than just your current pages.

### 1. Start a Blog

Add a blog section to your website with articles like:

**HR Compliance Topics:**
- "10 HR Compliance Mistakes Small Businesses Make"
- "Employee Handbook Requirements by State [2025]"
- "How to Conduct an HR Audit: Step-by-Step Guide"
- "FMLA, ADA, and Title VII: What Small Businesses Need to Know"

**Industry-Specific Content:**
- "HR Challenges Facing Behavioral Health Agencies"
- "Recruiting Tips for Nonprofit Organizations"
- "HR Best Practices for Community Health Centers"

**Leadership & Training:**
- "5 Signs Your Managers Need Leadership Coaching"
- "Building a Positive Workplace Culture in Small Businesses"
- "Employee Relations: When to Seek Expert Help"

**Frequency:** 1-2 blog posts per month (minimum)

### 2. Service Detail Pages

Expand your services page into individual pages:
- `/services/hr-compliance.html`
- `/services/recruiting.html`
- `/services/employee-handbooks.html`
- `/services/employee-relations.html`
- `/services/leadership-coaching.html`

Each page should have:
- 800-1,200 words of content
- Clear benefits and process
- Case studies or examples
- Call-to-action (book consultation)

### 3. Case Studies / Success Stories

Create pages showing your results:
- "How We Helped [Behavioral Health Agency] Pass an HR Audit"
- "Reducing Turnover by 40% at [Small Business Name]"
- "Building an Employee Handbook for [Community Org]"

(Use client names with permission, or anonymize)

### 4. FAQ Page

Create `faq.html` with common questions:
- "What is HR consulting?"
- "When should I hire an HR consultant?"
- "How much does HR consulting cost?"
- "What's included in an HR audit?"
- "Do small businesses need HR compliance?"

---

## Local SEO

If you serve specific geographic areas:

### 1. Add Location Keywords

Update your content to include location:
- "HR consulting in [City, State]"
- "Maryland HR compliance consultant"
- "Small business HR services in [Region]"

### 2. Create Location Pages

If you serve multiple areas, create pages like:
- `/locations/maryland-hr-consulting.html`
- `/locations/dc-hr-consultant.html`
- `/locations/virginia-hr-services.html`

### 3. Get Listed in Local Directories

Submit your business to:
- **Yelp:** https://biz.yelp.com
- **Bing Places:** https://www.bingplaces.com
- **Yellow Pages:** https://www.yellowpages.com
- **Better Business Bureau:** https://www.bbb.org
- **Chamber of Commerce:** Your local chamber

**Keep NAP Consistent:**
NAP = Name, Address, Phone
- Use EXACT same format everywhere
- Example: "123 Main St" vs "123 Main Street" - pick one!

### 4. Local Content

Write blog posts about local HR topics:
- "Maryland Employment Law Updates for 2025"
- "HR Compliance Requirements for DC Businesses"
- "Best Practices for Virginia Small Business Owners"

---

## Link Building

Google ranks sites higher if other reputable sites link to you.

### 1. Easy Links to Get First

**Professional Associations:**
- Society for Human Resource Management (SHRM) - if you're a member
- Local business associations
- Professional HR groups

**Client Websites:**
- Ask satisfied clients to link to you
- Offer to write a guest blog post

**Partners & Vendors:**
- Payroll companies
- Benefits providers
- Business coaches/consultants

### 2. Guest Posting

Write articles for other sites:
- HR industry blogs
- Small business websites
- Local business journals

Include a link back to your site in your author bio.

### 3. Press & Media

**Local Press:**
- Send press releases to local business journals
- Offer to be quoted as an HR expert
- Comment on local business stories

**Online PR:**
- HARO (Help A Reporter Out): https://www.helpareporter.com
- Respond to journalist requests for HR expert quotes

### 4. Content Partnerships

Create valuable resources others will link to:
- Free downloadable guides (e.g., "HR Compliance Checklist")
- Infographics (e.g., "HR Laws Timeline")
- Templates (e.g., "Employee Handbook Template")

---

## Technical SEO Checklist

After deploying to GreenGeeks, verify these:

### Performance
- [ ] Site loads in under 3 seconds
- [ ] Images are compressed
- [ ] HTTPS is enabled (SSL certificate)
- [ ] Mobile-friendly (responsive design) ✓ Already done

### Indexing
- [ ] Sitemap submitted to Google Search Console
- [ ] All pages are indexed (check: `site:mahonetconsulting.com` in Google)
- [ ] No duplicate content issues
- [ ] Canonical URLs set correctly

### On-Page
- [ ] Each page has unique title tag
- [ ] Each page has unique meta description
- [ ] H1 tag on every page (only one per page)
- [ ] Images have descriptive alt text
- [ ] Internal links between pages

### Local (if applicable)
- [ ] Google Business Profile created
- [ ] NAP consistent across the web
- [ ] Local keywords in content
- [ ] Reviews on Google

---

## Ongoing SEO Maintenance

### Weekly Tasks (30 minutes)
- Check Google Search Console for errors
- Respond to any Google Business reviews
- Monitor keyword rankings (see tools below)

### Monthly Tasks (2-3 hours)
- Write 1-2 blog posts
- Update one service page with more content
- Check for broken links
- Review analytics (Google Analytics)
- Reach out for 2-3 backlinks

### Quarterly Tasks (Half day)
- Comprehensive SEO audit
- Update outdated content
- Check competitor rankings
- Review and adjust keyword strategy

---

## Free SEO Tools You Should Use

### Essential Tools

**1. Google Search Console** (Already discussed)
- https://search.google.com/search-console
- Free, official Google tool
- Shows which keywords you rank for

**2. Google Analytics**
- https://analytics.google.com
- Track website visitors and behavior
- See which pages get most traffic

**3. Google Business Profile** (Already discussed)
- https://www.google.com/business
- Manage your Google listing

### Keyword Research Tools

**Free Options:**
- **Google Keyword Planner:** https://ads.google.com/home/tools/keyword-planner
- **AnswerThePublic:** https://answerthepublic.com (3 free searches/day)
- **Google Trends:** https://trends.google.com
- **Ubersuggest:** https://neilpatel.com/ubersuggest (3 free searches/day)

**Paid Options (Worth It):**
- **Semrush:** $129/month - Comprehensive SEO suite
- **Ahrefs:** $99/month - Best for backlink analysis
- **Moz Pro:** $99/month - Good all-around tool

### Rank Tracking

**Free:**
- Manual: Search in Google incognito mode for your keywords
- Google Search Console (shows average position)

**Paid:**
- Semrush, Ahrefs, or Moz (all include rank tracking)

### Site Speed Testing

- **Google PageSpeed Insights:** https://pagespeed.web.dev
- **GTmetrix:** https://gtmetrix.com

---

## Realistic Timeline & Expectations

### Month 1-2: Foundation
**Tasks:**
- ✅ Deploy website with SEO improvements
- ✅ Set up Google Search Console
- ✅ Submit sitemap
- ✅ Create Google Business Profile (if applicable)
- ✅ Write 2-4 blog posts
- ✅ Get listed in 5-10 directories

**Expected Results:**
- Website appears in Google for branded searches ("MahoneT HR Consulting")
- Google starts crawling and indexing pages
- No traffic yet from generic searches

### Month 3-4: Early Growth
**Tasks:**
- Write 2-3 blog posts per month
- Get 3-5 backlinks
- Collect 5-10 Google reviews
- Monitor Google Search Console data

**Expected Results:**
- Appear on page 2-3 for long-tail keywords
- Start getting 10-20 visitors per month from Google
- Appear in Google Maps (if you have local listing)

### Month 5-6: Momentum Building
**Tasks:**
- Continue content creation
- Build more backlinks
- Update and expand existing content
- Create downloadable resources

**Expected Results:**
- Appear on page 1 for some long-tail keywords
- 50-100+ visitors per month from Google
- Start getting inquiries from organic search

### Month 12+: Established Presence
**Tasks:**
- Maintain consistent content schedule
- Focus on high-value keywords
- Build authority through guest posts and PR

**Expected Results:**
- Rank on page 1 for multiple long-tail keywords
- Potentially rank on page 1-2 for "HR consulting [your city]"
- 200-500+ visitors per month from Google
- Regular consultation bookings from search

---

## Why "HR Consulting" Is Challenging

**High Competition:**
- Big HR firms with massive budgets
- Established companies with years of SEO
- National HR platforms and directories

**Better Strategy:**
Focus on these instead:
1. **Niche keywords:** "HR consulting for behavioral health"
2. **Local keywords:** "HR consultant in [your city]"
3. **Long-tail keywords:** "employee handbook development services"
4. **Industry-specific:** "HR compliance for small nonprofits"

**You'll rank faster for:**
- "HR consultant for behavioral health agencies Maryland"
- Than for: "HR consulting"

---

## Next Steps (Priority Order)

### 🔴 HIGH PRIORITY (Do First)

1. **Deploy website** with SEO improvements (files already updated)
2. **Set up Google Search Console** (1 hour)
3. **Submit sitemap** to Google Search Console (5 minutes)
4. **Create Google Business Profile** if you have local presence (1 hour)
5. **Set up Google Analytics** (30 minutes)

### 🟡 MEDIUM PRIORITY (Do Within 2 Weeks)

6. **Write first 2 blog posts** (2-3 hours each)
7. **Get listed in 5 directories** (2 hours)
8. **Ask 3 clients for reviews** (30 minutes)
9. **Create downloadable lead magnet** (e.g., "HR Compliance Checklist") (3-4 hours)

### 🟢 LOW PRIORITY (Ongoing)

10. **Write 1-2 blog posts per month**
11. **Build backlinks** (reach out for guest posts, partnerships)
12. **Monitor rankings** and adjust strategy
13. **Update old content** quarterly

---

## Need Professional Help?

**When to Hire an SEO Expert:**
- You don't have 5-10 hours/month for SEO
- You want faster results
- You're willing to invest $500-$2,000/month
- You want to rank for competitive keywords

**What They'll Do:**
- Technical SEO audit and fixes
- Comprehensive keyword research
- Content strategy and creation
- Link building campaigns
- Monthly reporting and adjustments

**Where to Find SEO Help:**
- Upwork or Fiverr (freelancers, $500-$1,500/month)
- Local SEO agencies ($1,000-$3,000/month)
- National SEO firms ($2,000-$10,000+/month)

---

## Summary

✅ **Technical SEO:** I've updated your website files with proper meta tags, structured data, sitemap, and robots.txt

🎯 **Next Actions You Need to Take:**
1. Deploy updated website to GreenGeeks
2. Set up Google Search Console (CRITICAL!)
3. Submit sitemap
4. Create Google Business Profile (if local)
5. Start creating content (blog posts)
6. Build backlinks over time

⏰ **Timeline:**
- 3-6 months to see real results
- Focus on niche/local keywords first
- "HR consulting" alone is very competitive

📈 **Realistic Goal:**
Rank on page 1 for: "HR consulting for behavioral health agencies [your area]"
Within 6 months with consistent effort

---

**Questions?** Let me know and I can provide more specific guidance on any section!

Last updated: November 6, 2025
