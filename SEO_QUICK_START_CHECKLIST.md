# SEO Quick Start Checklist
## After Deploying to GreenGeeks

Use this checklist to ensure your website is properly optimized for Google search.

---

## ✅ Technical SEO (Already Done)

These improvements have already been implemented in your website files:

- [x] **Meta tags added** to all pages (title, description, keywords)
- [x] **Open Graph tags** for social media sharing
- [x] **Structured data (Schema.org)** on homepage for business info
- [x] **Canonical URLs** to prevent duplicate content
- [x] **sitemap.xml created** - Lists all pages for Google
- [x] **robots.txt created** - Tells search engines what to crawl
- [x] **Admin page protected** - Added noindex tag
- [x] **Responsive design** - Mobile-friendly (already done)
- [x] **HTTPS ready** - SSL certificate through GreenGeeks

---

## 🔴 CRITICAL - Do These First (Within 24 Hours of Launch)

### 1. Set Up Google Search Console (30 minutes)
**Why:** This is THE most important step. Without it, Google won't know your site exists.

**Steps:**
1. Go to: https://search.google.com/search-console
2. Click "Add Property" → Enter: `https://mahonetconsulting.com`
3. Verify ownership using HTML file upload method (easiest)
4. Submit your sitemap: `sitemap.xml`
5. Done! Google will start crawling within 48 hours

**See:** `SEO_IMPLEMENTATION_GUIDE.md` - Section "Google Search Console Setup" for detailed instructions

### 2. Set Up Google Analytics (30 minutes)
**Why:** Track visitors and see which keywords bring traffic

**Steps:**
1. Go to: https://analytics.google.com
2. Create account → Add property for mahonetconsulting.com
3. Get tracking code
4. Add tracking code to all HTML pages (between `<head>` tags)

**Tracking Code Format:**
```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

### 3. Update Schema Markup Phone Number (5 minutes)
**Current Status:** Placeholder in index.html
**Location:** Line 37 in `index.html`

**Find:**
```json
"telephone": "+1-XXX-XXX-XXXX",
```

**Replace with your actual phone:**
```json
"telephone": "+1-555-123-4567",
```

Or remove the line entirely if you don't want to display phone publicly.

---

## 🟡 HIGH PRIORITY - Do Within First Week

### 4. Create Google Business Profile (1 hour)
**Only if you have a physical location or serve local customers**

**Steps:**
1. Go to: https://www.google.com/business
2. Create profile for "MahoneT HR Consulting"
3. Add all business info (address, phone, website, hours)
4. Upload logo and photos
5. Verify business (Google will mail postcard or call)

**See:** `SEO_IMPLEMENTATION_GUIDE.md` - Section "Google Business Profile"

### 5. Get Listed in Directories (2 hours)
Submit your business to these directories with consistent NAP (Name, Address, Phone):

- [ ] Yelp: https://biz.yelp.com
- [ ] Bing Places: https://www.bingplaces.com
- [ ] Yellow Pages: https://www.yellowpages.com
- [ ] Better Business Bureau: https://www.bbb.org
- [ ] Local Chamber of Commerce

**Important:** Use EXACT same format everywhere:
- Business Name: MahoneT HR Consulting
- Address: (if applicable)
- Phone: (use same format everywhere)
- Website: https://mahonetconsulting.com

### 6. Start Creating Content (3-4 hours)
Write your first blog post on an HR topic. Ideas:

- "10 HR Compliance Mistakes Small Businesses Make"
- "When Should You Hire an HR Consultant?"
- "Employee Handbook Essentials for Small Business"
- "HR Challenges in Behavioral Health Agencies"

**Blog setup:**
1. Create a `blog/` folder
2. Create `blog/index.html` (blog listing page)
3. Create individual blog post HTML files
4. Update navigation to include Blog link

---

## 🟢 MEDIUM PRIORITY - Do Within First Month

### 7. Ask for Reviews (Ongoing)
If you have Google Business Profile:
- Ask 3-5 satisfied clients for Google reviews
- Send them direct link to review page
- Respond to all reviews professionally

### 8. Build Backlinks
Reach out to get other sites to link to you:
- [ ] Contact 3 business partners for links
- [ ] Reach out to 2 HR associations
- [ ] Guest post on 1 industry blog
- [ ] Submit to HR consulting directories

### 9. Optimize Images
All images should have descriptive alt text. Check these:

**Current images to verify:**
- `img/logo.jpg` - Alt: "MahoneT HR Consulting Logo"
- `img/main-image.jpg` - Alt: "Professional HR Consultant"
- `img/behavioral-health-placeholder.jpg` - Alt text already set
- `img/small-business-placeholder.jpg` - Alt text already set
- `img/community-orgs-placeholder.jpg` - Alt text already set

### 10. Add Social Media Links
If you have social media profiles, add them:

**Update Schema Markup (index.html line 46):**
```json
"sameAs": [
  "https://www.linkedin.com/company/mahonet-consulting",
  "https://www.facebook.com/mahonetconsulting",
  "https://twitter.com/mahonethr"
]
```

**Add social icons to footer** (optional)

---

## 📊 Ongoing Maintenance (Monthly)

### Content Creation
- [ ] Write 1-2 blog posts per month
- [ ] Update service pages with more detail
- [ ] Create downloadable resources (checklists, guides)

### Monitoring
- [ ] Check Google Search Console for errors
- [ ] Review Google Analytics traffic
- [ ] Monitor keyword rankings
- [ ] Respond to reviews (if applicable)

### Link Building
- [ ] Reach out for 2-3 new backlinks per month
- [ ] Guest post opportunities
- [ ] Partner websites

---

## 🎯 Target Keywords (Focus on These)

### Primary Long-Tail Keywords (Start Here)
These are more realistic to rank for:

1. **"HR consulting for small business"**
2. **"HR consultant for behavioral health"**
3. **"HR compliance small business [your state]"**
4. **"employee handbook development services"**
5. **"HR audit services"**

### Location-Based Keywords (If Applicable)
Add your city/state:

- "HR consultant [City, State]"
- "HR consulting services [City]"
- "small business HR [State]"

### Avoid These (Too Competitive)
- "HR consulting" - Too broad, huge competition
- "HR consultant" - Very competitive
- "Human resources" - Too generic

Focus on niche, specific keywords instead!

---

## ⏰ Realistic Timeline

### Week 1
- Deploy website
- Set up Google Search Console
- Submit sitemap
- Set up Google Analytics

### Week 2-3
- Create Google Business Profile (if applicable)
- Get listed in 5 directories
- Write first blog post

### Month 2
- Google indexes your pages
- You appear for branded searches ("MahoneT HR Consulting")
- Start appearing on page 2-3 for long-tail keywords

### Month 3-4
- More pages indexed
- Rank on page 1 for some long-tail keywords
- 20-50 visitors/month from Google

### Month 6+
- Established presence for niche keywords
- 100-200+ visitors/month from Google
- Start getting consultation inquiries from search

---

## 📝 Quick Reference: Files Updated

### HTML Files (SEO Meta Tags Added)
- ✅ `index.html` - Homepage with full Schema markup
- ✅ `about.html` - About page meta tags
- ✅ `services.html` - Services page meta tags
- ✅ `contact.html` - Contact page meta tags
- ✅ `booking.html` - Booking page meta tags
- ✅ `admin.html` - Protected with noindex tag

### New Files Created
- ✅ `sitemap.xml` - Submit to Google Search Console
- ✅ `robots.txt` - Directs search engine crawlers
- ✅ `SEO_IMPLEMENTATION_GUIDE.md` - Comprehensive guide
- ✅ `SEO_QUICK_START_CHECKLIST.md` - This file

### Files to Upload to GreenGeeks
All of the above files should be uploaded to your `public_html` folder.

---

## 🆘 Common Issues & Solutions

### "My site isn't showing up in Google"
**Solution:**
- Wait 2-4 weeks after submitting sitemap
- Check Google Search Console for indexing issues
- Manually request indexing in Search Console

### "I'm not ranking for 'HR consulting'"
**Normal!** That keyword is extremely competitive.
- Focus on long-tail keywords instead
- Add location to searches
- Target niche keywords (behavioral health, small business, etc.)

### "No traffic after 1 month"
**This is normal!** SEO takes 3-6 months.
- Keep creating content
- Keep building backlinks
- Be patient and consistent

---

## 📚 Resources

### Free SEO Tools
- **Google Search Console:** https://search.google.com/search-console
- **Google Analytics:** https://analytics.google.com
- **Google PageSpeed Insights:** https://pagespeed.web.dev
- **Google Keyword Planner:** https://ads.google.com/home/tools/keyword-planner

### Learning Resources
- **Google's SEO Starter Guide:** https://developers.google.com/search/docs/fundamentals/seo-starter-guide
- **Moz Beginner's Guide to SEO:** https://moz.com/beginners-guide-to-seo

---

## ✉️ Need Help?

Refer to the comprehensive guide: **`SEO_IMPLEMENTATION_GUIDE.md`**

It includes:
- Detailed instructions for every step
- Content strategy ideas
- Link building tactics
- Local SEO guide
- Troubleshooting section
- Timeline and expectations

---

## Summary

**✅ Done (Technical SEO):**
- All meta tags, Schema markup, sitemap, robots.txt

**🔴 You Need to Do (Critical):**
1. Set up Google Search Console
2. Submit sitemap
3. Set up Google Analytics

**⏰ Timeline:**
- Week 1: Deploy + setup tools
- Month 2-3: Start appearing in search
- Month 6+: Rank for niche keywords

**🎯 Focus:**
- Long-tail keywords (not just "HR consulting")
- Location-based searches (if applicable)
- Niche keywords (behavioral health, small business)

**Good luck with your SEO journey! 🚀**

---

Last updated: November 6, 2025
