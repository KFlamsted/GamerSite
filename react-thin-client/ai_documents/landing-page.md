# Landing Page Implementation Plan

## Overview
Build a landing page with a fullscreen background video, centered title "Novaz gamer", and an animated scroll-down indicator.

## Project Analysis

### Current Setup
- **Build tool**: Vite + React + TypeScript
- **React version**: 19.2.0
- **Current structure**: Standard Vite scaffold with App.tsx, main.tsx, and basic styling
- **Font requirement**: Bebas Neue (needs to be added to project)

## Implementation Steps

### 1. Cleanup Phase
**Files to remove:**
- `src/App.css` (will create new component-specific CSS files)
- `src/assets/react.svg`
- `public/vite.svg`

**Files to modify:**
- `src/App.tsx` - Remove boilerplate, import LandingPage component
- `src/index.css` - Keep but simplify, remove boilerplate styles
- `index.html` - Add Bebas Neue font from Google Fonts

### 2. Font Integration
Add Bebas Neue font to `index.html`:
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
```

### 3. Folder Structure Creation
```
src/
├── landingPage/
│   ├── BackgroundVideoComponent.tsx
│   ├── BackgroundVideoComponent.css
│   └── LandingPage.tsx
├── components/
│   └── ScrollDownIndicator/
│       ├── ScrollDownIndicator.tsx
│       └── ScrollDownIndicator.css
```

### 4. Public Assets
```
public/
└── videos/
    └── background.mp4 (placeholder reference - user will add actual video)
```

### 5. Component Details

#### BackgroundVideoComponent.tsx
- **Purpose**: Render fullscreen background video with dark overlay
- **Props**: `videoSrc: string` (path to video file)
- **Structure**:
  - `<div>` wrapper with dark overlay filter
  - `<video>` element with autoPlay, muted, loop, playsInline
- **CSS specifications**:
  - Position: fixed (to stay in background during scroll)
  - Dimensions: 100vw × 100vh
  - z-index: -1
  - object-fit: cover (maintain aspect ratio)
  - Dark filter overlay: rgba(0, 0, 0, 0.35)

#### LandingPage.tsx
- **Purpose**: Main landing page composition
- **Structure**:
  - Renders `BackgroundVideoComponent` with video path
  - Renders centered `<h1>` with title "Novaz gamer"
  - Renders `ScrollDownIndicator` at bottom
- **Layout**:
  - Container div with min-height: 100vh
  - Flexbox layout for vertical centering
  - Title positioned in top-center area
  - Scroll indicator at bottom

#### ScrollDownIndicator Component
- **Purpose**: Reusable animated arrow/indicator for scroll feedback
- **Location**: `src/components/ScrollDownIndicator/`
- **Structure**:
  - Container div
  - Down arrow icon (using CSS or Unicode character ↓ or ▼)
- **Animation**:
  - CSS keyframe animation
  - Vertical bounce effect (translateY)
  - Continuous loop with ease-in-out timing
  - Movement: ~10-15px up and down

### 6. Styling Specifications

#### Title (h1) Styling
```css
font-family: 'Bebas Neue', sans-serif;
color: white;
font-weight: bold;
font-size: 4rem (or larger, like 5-6rem);
text-shadow: 
  - Dense drop shadow: 0px 4px 8px rgba(0, 0, 0, 0.8)
  - Small dark border effect: multiple text-shadows with small offsets
text-align: center;
```

#### Global Resets (index.css)
- Remove default margins/paddings
- Set box-sizing: border-box
- Ensure body and #root take full height

### 7. Video Element Configuration
```tsx
<video
  autoPlay
  muted
  loop
  playsInline
  src="/videos/background.mp4"
>
  Your browser does not support the video tag.
</video>
```

**Note**: Video will be stored in `public/videos/` folder and referenced as `/videos/background.mp4`

### 8. Integration in App.tsx
- Remove all boilerplate code
- Import and render only `LandingPage` component
- Keep it clean and simple

## Technical Considerations

### Browser Compatibility
- `playsInline` attribute needed for iOS Safari autoplay
- Video should be muted for autoplay to work across browsers
- Fallback message for browsers without video support

### Performance
- Video overlay filter using CSS (more performant than multiple divs)
- CSS transforms for scroll indicator animation (hardware accelerated)
- Lazy loading consideration for future video optimization

### Responsiveness
- Video: `object-fit: cover` ensures proper scaling
- Title: Consider reducing font-size on mobile (@media queries)
- Scroll indicator: Position absolute at bottom with margin

## File Modification Summary

| Action | File Path |
|--------|-----------|
| DELETE | `src/App.css` |
| DELETE | `src/assets/react.svg` |
| DELETE | `public/vite.svg` |
| MODIFY | `src/App.tsx` |
| MODIFY | `src/index.css` |
| MODIFY | `index.html` |
| CREATE | `src/landingPage/BackgroundVideoComponent.tsx` |
| CREATE | `src/landingPage/BackgroundVideoComponent.css` |
| CREATE | `src/landingPage/LandingPage.tsx` |
| CREATE | `src/components/ScrollDownIndicator/ScrollDownIndicator.tsx` |
| CREATE | `src/components/ScrollDownIndicator/ScrollDownIndicator.css` |
| CREATE | `public/videos/` (folder) |

## Next Steps: Scroll Mechanic (Future Implementation)

When ready to implement scroll-down functionality:

1. **Content Sections**: Create additional page sections below the landing page (About, Features, etc.)

2. **Smooth Scroll**: 
   - Add `scroll-behavior: smooth` to CSS
   - Or use a library like `react-scroll` for more control

3. **Scroll Trigger**:
   - Add onClick handler to ScrollDownIndicator
   - Use `window.scrollTo()` or `element.scrollIntoView()`
   - Target next section (e.g., `document.getElementById('about-section')`)

4. **Enhanced Animation**:
   - Fade out landing page elements on scroll
   - Use Intersection Observer API or scroll event listeners
   - Consider parallax effects for background video

5. **Navigation**:
   - Add sticky header with navigation links
   - Implement scroll-to-section functionality
   - Highlight active section in navigation

**Simple Implementation Example**:
```tsx
const handleScrollDown = () => {
  window.scrollTo({
    top: window.innerHeight,
    behavior: 'smooth'
  });
};
```

---

## Ready for Implementation
Once approved, I'll proceed with building all components according to this plan.
