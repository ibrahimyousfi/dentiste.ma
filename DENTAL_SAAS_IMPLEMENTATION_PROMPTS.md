Dental Clinic SaaS --- V1 Prompt Library

Use these prompts sequentially. The project overview is the sourceof truth.

Global instruction

For every prompt: inspect the existing repository first; preserve theexisting stack and conventions; do not rewrite working codeunnecessarily; implement only the requested scope; includemigrations/models/services/API/UI/tests appropriate to the stack;protect tenant isolation and authorization; report changes and tests; donot introduce AI or unrelated V2 features.

Prompt 01 --- Foundation, SaaS and Authentication

Goal: establish the secure multi-tenant foundation.

Implement together: - project architecture baseline; -organizations/clinics and branches; - authentication; - users; - rolesand granular permissions; - clinic settings; - tenant isolation; -audit-log foundation.

Roles: Super Admin, Clinic Owner, Dentist, Receptionist, Assistant,Accountant.

Acceptance: a clinic can be created, users can authenticate,permissions work, and cross-tenant data access is impossible.

Prompt 02 --- Patient and Medical Record

Goal: make the patient profile the central record.

Implement together: - patient CRUD/search/filtering; -personal/contact/identification/insurance data; - medical history; -allergies, medications, conditions; - notes; - patient timelinefoundation; - document storage, categories, metadata, secure access; -patient profile UI.

All future clinical, financial, appointment, image, laboratory, andreimbursement records must link to the patient rather than duplicatepatient data.

Acceptance: staff can register/search a patient and access onecentral profile containing the patient's records and documents.

Prompt 03 --- Dental Chart and Examination

Goal: digitize the paper dental card.

Implement together: - adult and child dentition; - toothnumbering/model; - interactive dental chart; - configurable toothstatuses; - examinations; - findings; - clinical notes; - tooth-specificprocedures; - chronological tooth history.

The workflow must be:

Patient → Examination → Select tooth → Mark finding/status → Add note/procedure → Save → View history

The chart must be fast enough for real chair-side use.

Prompt 04 --- Treatment and Appointments

Goal: connect clinical findings to treatment execution andscheduling.

Implement together: - treatment catalog/categories/prices; - treatmentplans; - treatment-plan items and estimated costs; - treatmentstatuses; - multi-session treatments; - session notes/procedures; -calendar day/week/month; - doctor schedules; - rooms/chairs wheresupported; - appointment statuses; - waiting list; - reception workflow.

A treatment must support multiple sessions, and appointments should linkto patients and treatment sessions when appropriate.

Prompt 05 --- Finance, Documents and Reimbursement

Goal: eliminate manual financial and reimbursement paperwork.

Implement together: - estimates; - invoices/items; - payments andmethods; - partial payments/installments; - outstanding balances; -expenses; - insurance providers; - reimbursement cases/statuses; -document templates; - prescriptions; - treatment reports; -certificates; - printable treatment sheets; - receipts; - reimbursementpackages; - first concrete CNSS workflow.

Critical rule: enter information once and reuse it. Existingtreatment/session/payment data must populate reimbursement documentsautomatically.

Acceptance: the clinic can calculate treatment cost, invoice it,record payments, track remaining balance, create a reimbursement case,generate its documents, and print them without rewriting the treatment.

Prompt 06 --- Images, Laboratory and Inventory

Goal: complete treatment-related operational resources.

Implement together:

Images

X-rays, panoramic/CBCT categories, clinical photos, before/aftergrouping, optional tooth association, secure metadata.

Laboratory

laboratories, contacts, lab orders, patient/treatment/tooth linkage,status, sent/expected/received dates, documents.

Inventory

products, categories, suppliers, purchases, stock levels, stockmovements, consumption, low-stock thresholds, inventory history.

Acceptance: treatments can reference images and laboratory work,while the clinic can independently manage stock, suppliers, purchases,and consumption.

Prompt 07 --- Reports, Notifications, Security and Production QA

Goal: turn the modules into a production-ready V1.

Implement together: - patient, appointment, treatment, financial andoperational reports; - internal notifications; - appointment/paymentreminder infrastructure; - permission and authorization review; -tenant-isolation review; - audit-log completion; - secure file access; -validation and error handling; - unit/integration/workflow tests; -finance calculation tests; - appointment-state tests; -reimbursement/document tests; - regression testing; - performance andproduction configuration review.

Do not add new features.

Acceptance: a real clinic can operate the complete lifecycle safelyfrom registration through treatment, payment, reimbursement, reportingand follow-up.

Final V1 Audit Prompt

After Prompts 01--07 are complete:

Audit the entire implementation againstDENTAL_SAAS_PROJECT_OVERVIEW.md.

Test:

Patient → Appointment → Examination → Dental Chart → Treatment Plan → Session → Invoice → Payment → Documents → Reimbursement → Reports

Also verify multi-tenancy, permissions, audit logs, secure documents,financial calculations, tooth history, printing,responsive/error/loading states, migrations, and database integrity.

Fix only defects required for V1 correctness and stability.

Return: - completed requirements; - failed tests; - remaining bugs; -security concerns; - performance concerns; - production blockers.

Do not start AI development.