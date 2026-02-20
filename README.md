# BookingKoro

Child theme of **GeneratePress** for [bookingkoro.com](https://bookingkoro.com).

## Requirements

- WordPress 6.5+
- GeneratePress theme (parent) installed and active

## Installation

1. Ensure **GeneratePress** is installed under `wp-content/themes/generatepress`.
2. Activate **BookingKoro** under **Appearance → Themes**.

## Customization

- **Styles:** Add CSS in `style.css` or create `assets/css/custom.css` and enqueue it in `functions.php`.
- **Templates:** Override parent templates by copying them from GeneratePress into this theme and editing.
- **Functions:** Add hooks, filters, and custom PHP in `functions.php`.

## Structure

```
bookingkoro/
├── style.css       # Theme header + custom CSS
├── functions.php   # Theme setup and enqueues
└── README.md       # This file
```

Add a `screenshot.png` (1200×900 px) in the theme folder to show a preview in **Appearance → Themes**.
