---
name: Rural Harmony Administrative System
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#3d4a42'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#6d7a72'
  outline-variant: '#bccac0'
  surface-tint: '#006c4a'
  primary: '#006948'
  on-primary: '#ffffff'
  primary-container: '#00855d'
  on-primary-container: '#f5fff7'
  inverse-primary: '#68dba9'
  secondary: '#545f73'
  on-secondary: '#ffffff'
  secondary-container: '#d5e0f8'
  on-secondary-container: '#586377'
  tertiary: '#595c5e'
  on-tertiary: '#ffffff'
  tertiary-container: '#727577'
  on-tertiary-container: '#fbfdff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#85f8c4'
  primary-fixed-dim: '#68dba9'
  on-primary-fixed: '#002114'
  on-primary-fixed-variant: '#005137'
  secondary-fixed: '#d8e3fb'
  secondary-fixed-dim: '#bcc7de'
  on-secondary-fixed: '#111c2d'
  on-secondary-fixed-variant: '#3c475a'
  tertiary-fixed: '#e0e3e5'
  tertiary-fixed-dim: '#c4c7c9'
  on-tertiary-fixed: '#191c1e'
  on-tertiary-fixed-variant: '#444749'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  display-lg:
    fontFamily: Work Sans
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Work Sans
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
  headline-sm:
    fontFamily: Work Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: JetBrains Mono
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.05em
  headline-md-mobile:
    fontFamily: Work Sans
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  sidebar-width: 280px
  header-height: 64px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 32px
  stack-sm: 8px
  stack-md: 16px
  stack-lg: 32px
---

## Brand & Style

This design system blends **Corporate Modern** efficiency with a **Minimalist** aesthetic to serve administrative users managing rural and environmental data. The objective is to evoke a sense of calm, precision, and ecological stewardship. 

The interface prioritizes high legibility and functional density. It utilizes a restrained color palette and generous whitespace to reduce cognitive load during complex data entry and monitoring tasks. The aesthetic is clean and systematic, ensuring that administrative actions feel deliberate and reliable.

## Colors

The palette is anchored by a deep Emerald Green primary, representing growth and environmental health. 

### Administrative Palette
- **Primary Admin Nav:** The sidebar utilizes a deep forest green (`#064E3B`) to provide a strong visual anchor for the application frame, contrasting against the light content area.
- **Alert System:** Success, Error, Warning, and Info states use high-saturation tones for immediate recognition. Error states specifically utilize a crisp crimson to ensure visibility against the green primary accents.
- **Surface Colors:** Neutral grays are used for borders and secondary text to maintain a professional, de-cluttered environment.

## Typography

The typographic hierarchy distinguishes between narrative content and technical data. 

- **Work Sans** provides a sturdy, professional foundation for headings and section titles.
- **Inter** is utilized for all body copy and interface elements to ensure maximum legibility across all browser rendering engines.
- **JetBrains Mono** is reserved for administrative labels, metadata, and status tags, providing a "technical" feel that separates data attributes from prose.

## Layout & Spacing

The system uses a **Fixed Sidebar** with a **Fluid Content** area. 

- **Grid:** A 12-column grid is used for desktop views. Administrative forms should generally occupy a maximum of 8 columns to maintain optimal line length.
- **Sidebar:** Fixed at 280px. On tablet devices, the sidebar collapses into an icon-only rail or a hidden drawer.
- **Density:** The spacing rhythm follows an 8px base unit. For data-heavy tables, vertical padding may be reduced to 12px (stack-sm + 4px) to increase information density.

## Elevation & Depth

This design system uses **Tonal Layers** and **Low-contrast Outlines** rather than heavy shadows to maintain a flat, modern architectural feel.

- **Level 0 (Background):** The primary application background uses `#F8FAFC`.
- **Level 1 (Cards/Sidebar):** White surfaces with a 1px border of `#E2E8F0`.
- **Level 2 (Dropdowns/Modals):** Subtle ambient shadows (0px 4px 20px rgba(0, 0, 0, 0.05)) are permitted only for floating elements that sit above the primary content plane.
- **Interactive Depth:** Buttons use a slight vertical offset (1px) on hover to indicate tactility without departing from the flat aesthetic.

## Shapes

The shape language is **Soft** and systematic.

- **Standard Elements:** Buttons, input fields, and cards use a 0.25rem (4px) radius to maintain a professional, slightly technical appearance.
- **Containers:** Larger containers like modals or dashboards use the `rounded-lg` (8px) setting.
- **Indicators:** Status dots and certain toggle switches remain fully circular (pill-shaped) to distinguish them from actionable buttons.

## Components

### Administrative Sidebar
- **Background:** Deep Green (`#064E3B`).
- **Inactive Links:** 60% opacity white text.
- **Active State:** Solid Emerald (`#059669`) background for the menu item with 100% white text.
- **Icons:** 20px size, stroke-based.

### Form Inputs
- **Default:** White background, 1px `#CBD5E1` border.
- **Focus:** 1px `#059669` border with a 3px soft outer glow in the same color (20% opacity).
- **Error:** 1px `#EF4444` border. Text labels above inputs should be `label-md`.

### Alerts
- **Success:** Soft green background (`#ECFDF5`), emerald border (`#059669`), and dark green text.
- **Error:** Soft red background (`#FEF2F2`), red border (`#EF4444`), and dark red text.
- **Layout:** Standard icon on the left, message in the center, and optional "Close" action on the right.

### Buttons
- **Primary:** Emerald Green (`#059669`) with white text.
- **Secondary:** Slate (`#1E293B`) with white text.
- **Ghost:** Transparent background with slate text, appearing only on hover.

### Data Tables
- Header background: `#F1F5F9`.
- Row hover state: `#F8FAFC`.
- Divider lines: 1px `#E2E8F0`.