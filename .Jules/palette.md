## 2024-10-23 - Replaced Blocking Modals
**Learning:** The app used intrusive full-screen modals for basic loading states (e.g., "Por favor espere un momento"), which blocked interaction and felt disruptive.
**Action:** Replace these modals with inline loading indicators (spinners, disabled buttons) to maintain context and improve perceived performance.

## 2024-10-24 - Focus Management in Modals
**Learning:** Form validation errors triggered a modal but immediately stole focus to the input *behind* the overlay, trapping screen reader users in the background context while visually presenting a modal.
**Action:** When using modals for validation, pass the invalid element as a `focusTarget` to the modal function, and only restore focus to it *after* the modal is dismissed.
## 2024-02-28 - Missing visual feedback during form submission
**Learning:** The simple landing page forms lack any visual indication that the form is processing after submission, and error messages aren't announced to screen readers. This is a common pattern for fast-built forms where the focus is just getting data to the backend. Adding `aria-live="assertive"` on error divs and a `:disabled` state on buttons is a high-value, low-effort UX win.
**Action:** Always check if async form submissions provide immediate visual feedback (disabling the button) and accessible error reporting (`role="alert"`).
