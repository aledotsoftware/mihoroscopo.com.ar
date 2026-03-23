## 2024-10-23 - Replaced Blocking Modals
**Learning:** The app used intrusive full-screen modals for basic loading states (e.g., "Por favor espere un momento"), which blocked interaction and felt disruptive.
**Action:** Replace these modals with inline loading indicators (spinners, disabled buttons) to maintain context and improve perceived performance.

## 2024-10-24 - Focus Management in Modals
**Learning:** Form validation errors triggered a modal but immediately stole focus to the input *behind* the overlay, trapping screen reader users in the background context while visually presenting a modal.
**Action:** When using modals for validation, pass the invalid element as a `focusTarget` to the modal function, and only restore focus to it *after* the modal is dismissed.
## 2024-02-28 - Missing visual feedback during form submission
**Learning:** The simple landing page forms lack any visual indication that the form is processing after submission, and error messages aren't announced to screen readers. This is a common pattern for fast-built forms where the focus is just getting data to the backend. Adding `aria-live="assertive"` on error divs and a `:disabled` state on buttons is a high-value, low-effort UX win.
**Action:** Always check if async form submissions provide immediate visual feedback (disabling the button) and accessible error reporting (`role="alert"`).


## 2024-11-20 - Managing accessibility state in custom step-based JS flows
**Learning:** This app uses custom step-based navigation relying on standard JS event listeners (not inside actual `<form>` components for `landing.blade.php`), which inherently skips native form validation/loading announcements. When a submit triggers a loading state that alters the button to a spinner and disables inputs, screen readers can fall silent without context.
**Action:** Always explicitly implement `aria-busy="true"` and `aria-live="polite"` on the active submit button when initiating an asynchronous transition, ensuring to remove the attributes when the loading state resolves or throws an error, even if the user interface manages focus/disabled properties adequately.
## 2026-03-02 - Mobile Menu Accessibility
**Learning:** Custom interactive elements like '.menu-trigger' mimicking buttons must explicitly include keyboard events, tabindex, and ARIA roles (e.g., 'role="button"', 'aria-expanded') to avoid locking keyboard users out of core navigation.
**Action:** Always ensure that custom toggle buttons are accessible via keyboard ('Enter' / 'Space') and dynamically update ARIA attributes reflecting their state.

## 2024-11-21 - Replace Validation Modals with Inline Feedback
**Learning:** Using full-screen modals to display validation errors (e.g., "Please enter a valid email") disrupts the user's workflow, traps focus unhelpfully, and makes correcting the form difficult. Screen reader users may lose context of which input was invalid.
**Action:** Implement inline error messages (`<span role="alert">`) directly below the corresponding inputs instead of modals. Connect the error to the input using `aria-describedby` and `aria-invalid="true"` to ensure screen readers announce the specific error when the field is focused.

## 2024-10-27 - Consistency with explicit aria-required attributes
**Learning:** Even when native `required` attributes are present, relying on them alone can cause varying screen reader behavior, especially in complex or custom forms that mimic step-by-step progressions. `landing.blade.php` explicitly included `aria-required="true"`, but the variation `landing_2.blade.php` omitted it. Ensuring `aria-required="true"` consistently accompanies native `required` bolsters the accessibility of these fields across different screen readers.
**Action:** Always verify that custom form elements and variations explicitly mirror critical ARIA attributes like `aria-required="true"` present in primary templates to guarantee a consistent user experience.

## 2024-10-27 - Visual Required Indicators
**Learning:** Native `required` and `aria-required` attributes assist screen readers but offer zero help to sighted users trying to scan a form. In custom forms mimicking step-by-step progressions, omitting visual required indicators (like asterisks) increases cognitive load and form abandonment. Sighted users must easily see which fields are mandatory.
**Action:** Always include a visual required indicator (e.g., `<span class="required-indicator" aria-hidden="true">*</span>`) explicitly tied to the field's `<label>` when the field is marked as required. This provides an immediately recognizable cue and improves form completion rates.

## 2024-11-21 - Focus Management for Inline Validation
**Learning:** When using custom JS validation instead of native browser form submission, displaying inline errors with `role="alert"` is good, but focus remains on the submit button. This forces keyboard/screen reader users to manually navigate backwards to locate and fix the invalid input.
**Action:** Always programmatically move focus (`inputEl.focus()`) back to the invalid input when custom validation fails. This ensures immediate context for correction and pairs perfectly with `aria-invalid` announcements.

## 2024-11-23 - Clear Form Errors on Input
**Learning:** When users receive a form validation error (e.g., "invalid email" displayed as an inline error), they often start correcting the input immediately. If the error message and the `aria-invalid` state persist while they are typing, it can be confusing and frustrating, as the system still claims the input is "invalid" even while they are actively fixing it.
**Action:** Always add event listeners for `input` and `change` on form fields that clear any inline errors or `aria-invalid` attributes as soon as the user starts modifying the value. This provides immediate positive feedback and reduces cognitive friction.

## 2026-03-16 - Consistent Visual Required Indicators on Sub-pages
**Learning:** The main form ('landing.blade.php') includes visual required indicators ('*'), but secondary sub-pages like 'payment.blade.php' sometimes omit them even when fields have native 'required' attributes. This inconsistency degrades UX for sighted users scanning forms.
**Action:** Always ensure any form view or partial explicitly implements the required indicator ('<span class="required-indicator" aria-hidden="true">*</span>') to match the design system's accessibility standard for mandatory fields.

## 2026-03-23 - Payment Feedback Pages Missing Layout Context
**Learning:** Payment outcome pages (`success.blade.php`, `pending.blade.php`, `failure.blade.php`) were historically raw HTML fragments, leaving users stranded without main navigation or a way back if a process halted.
**Action:** Always wrap status/outcome pages in the main application layout (`@extends('mihoroscopo.layouts.app')`) and include a clear, accessible return action (like 'Volver al inicio') to prevent dead-end user flows.
