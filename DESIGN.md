---
name: Rural Harmony
colors:
  surface: '#faf8ff'
  surface-dim: '#d6d9ef'
  surface-bright: '#faf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f2ff'
  surface-container: '#ebedff'
  surface-container-high: '#e4e7fe'
  surface-container-highest: '#dee1f8'
  on-surface: '#171b2b'
  on-surface-variant: '#414844'
  inverse-surface: '#2c3041'
  inverse-on-surface: '#eff0ff'
  outline: '#717973'
  outline-variant: '#c1c8c2'
  surface-tint: '#3f6653'
  primary: '#012d1d'
  on-primary: '#ffffff'
  primary-container: '#1b4332'
  on-primary-container: '#86af99'
  inverse-primary: '#a5d0b9'
  secondary: '#7d562d'
  on-secondary: '#ffffff'
  secondary-container: '#ffca98'
  on-secondary-container: '#7a532a'
  tertiary: '#232726'
  on-tertiary: '#ffffff'
  tertiary-container: '#383d3b'
  on-tertiary-container: '#a3a7a5'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#c1ecd4'
  primary-fixed-dim: '#a5d0b9'
  on-primary-fixed: '#002114'
  on-primary-fixed-variant: '#274e3d'
  secondary-fixed: '#ffdcbd'
  secondary-fixed-dim: '#f0bd8b'
  on-secondary-fixed: '#2c1600'
  on-secondary-fixed-variant: '#623f18'
  tertiary-fixed: '#dfe3e1'
  tertiary-fixed-dim: '#c3c7c5'
  on-tertiary-fixed: '#181d1b'
  on-tertiary-fixed-variant: '#434846'
  background: '#faf8ff'
  on-background: '#171b2b'
  surface-variant: '#dee1f8'
typography:
  display-lg:
    fontFamily: Be Vietnam Pro
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Be Vietnam Pro
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Be Vietnam Pro
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
  headline-md-mobile:
    fontFamily: Be Vietnam Pro
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  title-lg:
    fontFamily: Be Vietnam Pro
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Work Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Work Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-sm:
    fontFamily: Work Sans
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
    letterSpacing: 0.02em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 8px
  container-max: 1280px
  gutter: 24px
  margin-desktop: 64px
  margin-mobile: 20px
---

## Brand & Style

The design system is built to evoke a sense of "Rural Harmony"—a bridge between traditional village life and modern digital connectivity. The brand personality is grounded, dependable, and neighborly. It avoids the coldness of typical tech platforms in favor of a warm, human-centric approach that feels as natural as the landscapes it represents.

The design style is **Modern Minimalist with Tactile Accents**. It utilizes heavy whitespace to reduce cognitive load for users of all ages, paired with subtle organic elements (soft shadows and generous radii) to feel approachable. The aesthetic is clean and professional, ensuring high utility for administrative tasks while remaining inviting for community members.

## Colors

The palette is derived from a natural landscape:
- **Primary (Deep Forest):** Used for navigation, primary buttons, and headings to establish authority and growth.
- **Secondary (Earthy Clay):** Used for call-to-actions and accents that require warmth and attention.
- **Tertiary (Mist White):** A soft, off-white used for section backgrounds to reduce eye strain compared to pure white.
- **Neutral (Slate):** Used for body text to maintain high legibility and a professional tone.

Maintain a minimum contrast ratio of 4.5:1 for all functional text. Use the Primary color for interactive states to signify stability.

## Typography

This design system prioritizes high readability and accessibility. 
- **Be Vietnam Pro** is used for headings to provide a contemporary, friendly, and open character.
- **Work Sans** is used for body text and interface labels; its professional and grounded nature ensures clarity for users of all technical fluencies.

For long-form reading, such as village news or community guidelines, use `body-lg` to accommodate older eyes. All headings should use the Deep Forest color to maintain clear content hierarchy.

## Layout & Spacing

The layout follows a **Fluid Grid** model with a focus on "Generous Breathability." 
- **Desktop:** 12-column grid with 24px gutters and 64px outer margins. 
- **Tablet:** 8-column grid with 20px gutters and 40px margins.
- **Mobile:** 4-column grid with 16px gutters and 20px margins.

Use spacing to group related community items. Horizontal sections should utilize the Tertiary (Mist White) color to create distinct content blocks without relying on harsh lines. Large "Hero" areas should use increased vertical padding (80px+) to emphasize the peaceful, rural aesthetic.

## Elevation & Depth

To maintain a "Welcoming" feel, this design system avoids harsh dropshadows. 
- **Surface Layers:** Use subtle tonal shifts between White and Tertiary (#F1F5F2) to define areas.
- **Shadows:** Use "Ambient Shadows"—extremely soft, low-opacity (4-8%) blurs with a slight green tint (#1B4332) to make elements feel like they are gently resting on the page.
- **Outlines:** Use soft, 1px borders in a muted version of the Primary color for form fields and cards to ensure structural clarity without adding visual noise.

## Shapes

The shape language is "Softly Geometric." 
- A standard **0.5rem (8px)** radius is applied to buttons, input fields, and small components to make them feel modern yet approachable.
- Larger containers, such as community cards and image carousels, should use **1rem (16px)** to emphasize the friendly brand identity.
- Icons should feature rounded caps and corners to match the softened edges of the UI components.

## Components

### Buttons
- **Primary:** Solid Deep Forest green with white text. High contrast, 8px radius.
- **Secondary:** Earthy Clay background or outline for less critical actions like "Learn More."
- **Ghost:** Transparent with Primary text for utility links in navigation.

### Cards
Cards are the primary vehicle for "Village News" and "Community Events." They should feature a white background, 16px rounded corners, and a 1px soft border. Image headers on cards should have the top corners rounded to match the container.

### Input Fields
Inputs should be tall (min 48px) to be touch-friendly for all ages. Use a 1px border that thickens and changes to the Primary green on focus. Labels must always be visible (not placeholder-only).

### Chips & Tags
Use chips for categories like "Agriculture," "Events," or "Notice Board." These should have a light green tint background with dark green text and a pill-shape (full round) to distinguish them from buttons.

### Navigation
A clean, top-fixed navigation bar using the Mist White background. Use ample spacing between links to prevent accidental clicks. Include a "Search" bar prominently for easy access to village services.