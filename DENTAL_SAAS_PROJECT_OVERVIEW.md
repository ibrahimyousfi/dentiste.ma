Dental Clinic SaaS --- V1

Product Overview

Dental Clinic SaaS is a multi-tenant SaaS platform for digitizing thecomplete workflow of dental clinics: patient registration, appointments,examination, dental chart, treatment plans, treatment sessions,payments, documents, reimbursement, laboratory, inventory, andreporting.

V1 principle

V1 is comprehensive but contains no AI. The architecture must remainAI-ready for a later phase without rebuilding the core.

Problems solved

Paper-based patient cards and handwritten dental charts.

Repeated manual writing of treatment information.

Difficult tooth and treatment history.

Manual appointment management and missed appointments.

Manual invoices, payments, installments, and balances.

Recreating treatment documents for reimbursement.

Scattered X-rays, photos, prescriptions, and reports.

Weak laboratory and inventory tracking.

Limited financial and operational visibility.

Lack of granular permissions, tenant isolation, and audit history.

Core patient lifecycle

New Patient
→ Registration
→ Appointment
→ Examination
→ Dental Chart
→ Findings
→ Treatment Plan
→ Price Estimate
→ Treatment Sessions
→ Payments
→ Documents / Reimbursement
→ Completion
→ Follow-up

V1 modules

SaaS foundation: organizations, branches, users, roles, permissions,authentication.

Patients: profile, medical history, notes, timeline.

Dental: adult/child chart, tooth status, examinations, findings,tooth history.

Treatment: catalog, prices, treatment plans, multi-sessiontreatments.

Appointments: calendar, doctors, rooms/chairs, statuses, waitinglist.

Finance: estimates, invoices, payments, installments, balances,expenses.

Documents: templates, prescriptions, reports, certificates, consentforms, printing.

Reimbursement: insurance providers, reimbursement cases, requireddocuments, CNSS workflow.

Images: X-rays, photos, before/after, tooth association.

Laboratory: laboratories, orders, status tracking, documents.

Inventory: products, suppliers, purchases, stock, consumption,low-stock alerts.

Reports: clinical, appointment, treatment, financial, operational.

Notifications: internal events and reminder infrastructure.

Security: audit logs, authorization, tenant isolation, secure fileaccess.

Critical clinical model

A treatment may contain multiple sessions:

Treatment
├── Session 1
├── Session 2
├── Session 3
└── Session 4

Each session can contain date, dentist, procedures, teeth, notes,materials, price, payment linkage, and documents.

Each tooth must have its own chronological history.

Reimbursement principle

Information is entered once and reused everywhere. Existing treatment,session, invoice, payment, and clinical data must be reusable whengenerating reimbursement documents. The dentist must not rewrite thesame treatment manually for every reimbursement request.

Multi-tenancy

Each organization/clinic owns isolated data. Future multi-branch supportmust not require redesigning the core data model.

Initial roles

Super Admin

Clinic Owner

Dentist

Receptionist

Assistant

Accountant

Permissions must be granular.

Fixed V1 rules

Do not change the product direction.

Do not add unrelated V2 features.

Do not introduce AI in V1.

Preserve clinical and financial history.

Prefer configurable business rules over hard-coded clinicassumptions.

Printing and document generation are first-class features.

The system must be usable by a real clinic, not only as a demo.

New ideas discovered during development go to a V2 backlog unlessrequired for V1 correctness.

V1 completion

A real clinic must be able to register patients, manage appointments,perform examinations, maintain the dental chart, create treatment plansand sessions, invoice and collect payments, manage documents andreimbursement, handle images/laboratory/inventory, view reports, managepermissions, audit important actions, and print required documents.

Future AI layer

Only after V1 is stable: voice-to-note, smart assistance, patientassistant, administrative automation, and image-analysis assistance.