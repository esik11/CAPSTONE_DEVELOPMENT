# Requirements Modeling - Table Descriptions (Concise Version)

## Chapter 4: Requirements Modeling

The researcher identified and described all the necessary system requirements for the Online Integrated Clinic Information System with Billing and E-Prescription. The following system requirements were categorized into general groups: input, process, output, performance, and control.

- **Input**: The information, data, or material placed into the system for processing.
- **Process**: The main action of the system, involving the manipulation, calculation, or transformation of the input data.
- **Output**: The result of the input data, which could be processed data, reports, responses, or finished goods.
- **Performance**: This was measured in terms of response time, throughput, or accuracy.
- **Control**: The control keys used within the system.

---

## Table 1: User Management - Create/Edit User

The table above outlines the User Management function, which allows doctors or administrators to manage user accounts within the system. The process begins with the input of key account details such as User ID, Name, Email, Username, Password, Role (Doctor/Patient), and Contact Number. These pieces of information are required to uniquely identify and authenticate each user. Once the necessary data is provided, the system processes this information by creating a new user account with role-based access control. The expected output is a successfully registered user account that can access the system based on assigned credentials. To ensure system integrity, the performance requirement specifies that the process does not duplicate accounts, with validation mechanisms to prevent multiple accounts with the same email and password encryption for security. Under control, the administrator is given the ability to add, edit, or delete user accounts, ensuring proper management of user access throughout the system.

---

## Table 2: Patient Registration

The table above outlines the Patient Registration function, which allows doctors to register new patients and create comprehensive patient profiles. The process begins with the input of essential patient information including Patient ID, First Name, Last Name, Date of Birth, Gender, Contact Number, Email, Complete Address, Emergency Contact details, Blood Type, Civil Status, and PhilHealth Number. These pieces of information are required to uniquely identify each patient and establish a complete demographic profile. Once the necessary data is provided, the system processes this information by creating a new patient record and automatically generating a unique Patient ID along with a linked user account for patient portal access. The expected output is a complete patient profile with an assigned Patient ID and an empty medical record ready for documentation. To ensure system integrity, the performance requirement specifies that the system validates all required fields, prevents duplicate patient records by checking existing emails and PhilHealth numbers, and auto-generates unique Patient IDs. Under control, the doctor is given the ability to add new patients, edit existing patient information, view patient profiles, and archive inactive patients.

---

## Table 3: Medical History Management

The table above outlines the Medical History Management function, which allows doctors to document and maintain comprehensive medical histories for each patient. The process begins with the input of detailed medical information across multiple categories including Medical Conditions with ICD-10 codes, Current Medications with dosages and frequencies, Allergies with severity levels, Surgical History, Hospitalization History, Gynecological History for female patients, Lifestyle History including smoking and alcohol use, and Family History. These pieces of information are required to build a complete medical profile that supports clinical decision-making and ensures patient safety. Once the necessary data is provided, the system processes this information by storing and organizing it into structured categories within the patient's medical record. The expected output is a comprehensive, up-to-date medical record that doctors can reference during patient encounters, with all historical information organized by category and displayed chronologically. To ensure patient safety, the performance requirement specifies that the system validates allergy information and displays prominent warnings during prescription entry, tracks potential medication interactions, maintains a complete history timeline, and provides searchable ICD-10 code databases. Under control, the doctor is given the ability to add new medical history entries, edit existing information, view complete medical histories, mark conditions as resolved, discontinue medications, and delete erroneous entries.

---

## Table 4: Appointment Booking

The table above outlines the Appointment Booking function, which allows patients to request appointments with doctors through the system. The process begins with the input of essential appointment details including Patient ID, Doctor ID, Appointment Date, Appointment Time, Appointment Mode (In-Clinic/Telemedicine), Urgency Priority (Routine/Urgent/Emergency), and Reason for Visit. These pieces of information are required to schedule appropriate consultation times and ensure doctors can prepare for patient encounters. Once the necessary data is provided, the system processes this information by creating an appointment request, checking the doctor's availability, and assigning a "Pending" status awaiting confirmation. The expected output is an appointment record with a unique Appointment ID and status indicator (Pending/Confirmed/Cancelled/Completed). To ensure system efficiency, the performance requirement specifies that the system prevents double-booking by checking availability in real-time, validates that dates are in the future, displays only available time slots, and sends automatic confirmation notifications. Under control, the patient is given the ability to book new appointments, reschedule existing appointments, cancel appointments with a reason, and view their appointment history.

---

## Table 5: Appointment Management (Doctor)

The table above outlines the Appointment Management function for doctors, which allows healthcare providers to review, approve, and manage patient appointment requests. The process begins with the input of appointment-related actions including Appointment ID, Status Updates, Reschedule Date and Time, Check-in confirmation, and Cancellation Reason. These pieces of information are required to maintain an organized appointment schedule and communicate availability to patients. Once the necessary data is provided, the system processes this information by updating the appointment status, logging all changes, and automatically triggering notifications to inform patients of any changes. The expected output is an updated appointment record with the new status clearly indicated, along with automated email notifications sent to patients. To ensure efficient appointment management, the performance requirement specifies that the system provides real-time calendar updates, prevents scheduling conflicts, logs all status changes with timestamps, and sends immediate notifications to patients. Under control, the doctor is given the ability to view all appointment requests, confirm pending appointments, decline appointments, reschedule appointments, check in patients, mark appointments as completed, and cancel appointments when necessary.

---

## Table 6: Consultation - Symptoms Documentation (Subjective)

The table above outlines the Consultation - Symptoms Documentation function, which allows doctors to record patient complaints and vital signs following the Subjective component of the SOAP documentation format. The process begins with the input of key clinical information including Chief Complaint, Symptom Templates, Symptom Notes, Onset, Duration, Severity, Aggravating and Relieving Factors, Associated Symptoms, Review of Systems, and Vital Signs (Blood Pressure, Heart Rate, Temperature, Respiratory Rate, Oxygen Saturation, Weight, Height). These pieces of information are required to document the subjective portion of the medical encounter, capturing the patient's perspective and current physiological status. Once the necessary data is provided, the system processes this information by structuring it into a standardized SOAP format, supporting both template-based and freetext entry modes. The expected output is a comprehensive symptom documentation record with recorded vital signs accessible throughout the consultation workflow. To ensure system efficiency, the performance requirement specifies that the system auto-saves drafts to prevent data loss, validates vital sign ranges and flags abnormal values, provides symptom templates for common complaints, and displays the patient's medical history in a sidebar. Under control, the doctor is given the ability to add symptom entries, edit documentation, save drafts, use templates, enter freetext descriptions, and navigate between consultation sections.

---

## Table 7: Consultation - Physical Examination (Objective)

The table above outlines the Consultation - Physical Examination function, which allows doctors to document objective physical examination findings following the Objective component of the SOAP format. The process begins with the input of systematic examination findings organized by body system including General Appearance, HEENT, Cardiovascular, Respiratory, Gastrointestinal, Musculoskeletal, Neurological, Skin, and Other Systems. These pieces of information are required to document objective clinical findings that the doctor observes during the physical examination. Once the necessary data is provided, the system processes this information by organizing findings into a structured, system-based format, supporting both template-based entry with normal finding checkboxes and freetext entry for detailed abnormal findings. The expected output is a complete physical examination record organized by body system, with clear documentation of both normal and abnormal findings. To ensure thorough documentation, the performance requirement specifies that the system provides a system-based examination checklist, supports both template and freetext documentation, allows marking systems as "not examined," displays previous examination findings for comparison, and organizes findings in a standardized format. Under control, the doctor is given the ability to add examination findings, edit documentation, save progress, select body systems to examine, use quick-select options for normal findings, and enter detailed descriptions for abnormal findings.

---

## Table 8: Consultation - Diagnosis (Assessment)

The table above outlines the Consultation - Diagnosis function, which allows doctors to record medical diagnoses following the Assessment component of the SOAP format. The process begins with the input of diagnostic information including ICD-10 Code, Diagnosis Name, Primary or Secondary Diagnosis Flag, Clinical Notes, and Differential Diagnoses. These pieces of information are required to document the doctor's clinical assessment and diagnostic conclusions based on symptoms and examination findings. Once the necessary data is provided, the system processes this information by recording the diagnosis with proper ICD-10 coding, allowing designation of one primary diagnosis while supporting multiple secondary diagnoses. The expected output is a structured diagnosis list with the primary diagnosis clearly marked, complete with ICD-10 codes and clinical notes. To ensure diagnostic accuracy, the performance requirement specifies that the system provides ICD-10 code search functionality with autocomplete, validates that codes are current and properly formatted, supports multiple diagnoses, clearly marks the primary diagnosis, and maintains a diagnosis history for each patient. Under control, the doctor is given the ability to add new diagnoses, edit existing entries, delete incorrect diagnoses, search the ICD-10 database, mark one diagnosis as primary, and document differential diagnoses.

---

## Table 9: Consultation - Prescription (Plan)

The table above outlines the Consultation - Prescription function, which allows doctors to generate prescriptions for medications as part of the Plan component of the SOAP format. The process begins with the input of detailed prescription information including Medicine Name, Dosage, Frequency, Duration, Route of Administration, Special Instructions, and Quantity. These pieces of information are required to create complete, unambiguous prescriptions that ensure patients receive the correct medications and understand how to take them safely. Once the necessary data is provided, the system processes this information by generating a structured prescription record, automatically checking the patient's documented allergies, and validating medication names through the medicine database. The expected output is a complete prescription list containing all prescribed medications with full details, formatted for inclusion in the consultation summary. To ensure patient safety, the performance requirement specifies that the system automatically checks for drug allergies and displays warnings, validates medication dosages, provides a searchable medicine database, displays current medications to identify interactions, and maintains a complete medication history. Under control, the doctor is given the ability to add new medications, edit prescription entries, delete medications, search the medicine database, view the patient's allergy list, and review current medications.

---

## Table 10: Consultation - Treatment Plan (Plan)

The table above outlines the Consultation - Treatment Plan function, which allows doctors to create comprehensive treatment and follow-up plans as part of the Plan component of the SOAP format. The process begins with the input of detailed treatment planning information including Treatment Instructions, Patient Education, Follow-up Date, Follow-up Instructions, Referrals, Laboratory Tests Ordered, and Lifestyle Recommendations. These pieces of information are required to create a complete care plan that guides the patient's treatment journey and ensures appropriate follow-up care. Once the necessary data is provided, the system processes this information by organizing all components into a structured format, automatically scheduling follow-up appointments if dates are specified, and generating referral documents if specialists are recommended. The expected output is a comprehensive treatment plan document that includes all therapeutic interventions, patient education points, follow-up scheduling, referral information, ordered tests, and lifestyle recommendations. To ensure treatment plan completeness, the performance requirement specifies that the system validates follow-up dates are in the future, provides treatment plan templates for common conditions, supports documentation of multiple treatment modalities, allows generation of referral letters, maintains a list of commonly ordered laboratory tests, and tracks whether follow-up appointments are completed. Under control, the doctor is given the ability to add treatment plan components, edit existing elements, save the treatment plan, schedule follow-up appointments, generate referral documents, order laboratory tests, and document lifestyle recommendations.

---

**Note:** Tables 11-37 descriptions will follow in subsequent sections.

**Generated:** December 16, 2025

## Table 11: Finalize Consultation

The table above outlines the Finalize Consultation function, which allows doctors to complete and sign off on consultations after all SOAP documentation has been entered. The process begins with the input of completed SOAP documentation and the doctor's digital signature. Once the necessary data is provided, the system processes this information by marking the consultation as completed, updating the appointment status, generating a consultation summary, and creating an audit log entry. The expected output is a finalized consultation record with a PDF summary and updated appointment status. To ensure data integrity, the performance requirement specifies that the system validates all required sections are completed, generates audit logs, sends patient notifications, and prevents further editing of finalized records. Under control, the doctor is given the ability to finalize consultations, sign records, generate PDF summaries, and view completed summaries.

---

## Table 12: Consultation History

The table above outlines the Consultation History function, which allows doctors to view all past consultations for a specific patient. The process begins with the input of the patient identifier and optional date range filters. Once the necessary data is provided, the system processes this information by retrieving all completed consultations and organizing them chronologically. The expected output is a list of consultations displayed on the patient overview page, showing dates, diagnoses, and action buttons for viewing summaries or downloading PDFs. To ensure efficient access to patient history, the performance requirement specifies that the system sorts consultations by date, provides filtering capabilities, enables quick access to summaries, and displays a collapsible section. Under control, the doctor is given the ability to view consultation history, filter by date range, access individual summaries, download PDFs, and expand or collapse the history section.

---

## Table 13: Notification System

The table above outlines the Notification System function, which allows the system to send automated notifications to users regarding important events. The process begins with the input of notification details including type, recipient, and message content. Once the necessary data is provided, the system processes this information by generating and sending email notifications and recording delivery status. The expected output is a notification successfully delivered to the user via email. To ensure reliable communication, the performance requirement specifies that the system delivers notifications in real-time, tracks delivery status, uses professional templates, and includes relevant details. Under control, the system automatically sends notifications based on predefined triggers, while users can view notification history and mark notifications as read.

---

## Table 14: Audit Logging

The table above outlines the Audit Logging function, which allows the system to automatically track and record all user activities for security and compliance. The process begins with the input of activity information including user identifier, action performed, affected records, and technical details. Once the necessary data is provided, the system processes this information by creating tamper-proof audit log entries. The expected output is a complete audit trail documenting who performed what action, when, and from where. To ensure audit trail integrity, the performance requirement specifies that the system automatically logs all activities, creates tamper-proof records, captures comprehensive information, and provides searchable logs. Under control, administrators are given the ability to view audit logs, search and filter by criteria, export logs for compliance reporting, and analyze activity patterns.

---

## Table 15: Doctor Profile Management

The table above outlines the Doctor Profile Management function, which allows doctors to maintain and update their professional information and practice settings. The process begins with the input of professional details including specialization, license number, contact information, and availability settings. Once the necessary data is provided, the system processes this information by updating the doctor's profile and reconfiguring the appointment scheduling system. The expected output is an updated doctor profile with current information and an adjusted appointment calendar. To ensure accurate scheduling, the performance requirement specifies that the system validates license numbers, prevents scheduling conflicts, updates calendar availability in real-time, and displays consultation fees to patients. Under control, the doctor is given the ability to edit profile information, configure availability, update consultation fees, and view their complete profile.

---

## Table 16: Patient List Management

The table above outlines the Patient List Management function, which allows doctors to view and manage all patients in the system. The process begins with the input of search queries, filter criteria for active or archived patients, and sort preferences. Once the necessary data is provided, the system processes this information by retrieving the patient list from the database, applying filters and search terms, and organizing results with pagination. The expected output is a paginated patient list displaying basic information, status indicators, and last consultation dates. To ensure efficient patient management, the performance requirement specifies that the system provides fast search and filtering capabilities, displays patient counts, shows last consultation dates for continuity of care, and supports sorting by various criteria. Under control, the doctor is given the ability to view the patient list, search by name or patient ID, filter by status, sort results, and archive inactive patients.

---

## Table 17: Patient Overview

The table above outlines the Patient Overview function, which allows doctors to access comprehensive patient information in a single dashboard view. The process begins with the input of the patient identifier. Once the necessary data is provided, the system processes this information by retrieving all patient data including demographics, medical history, consultation history, and appointments, and loading all related information in organized sections. The expected output is a complete patient overview dashboard displaying all medical information in categorized sections with quick access to medical history components. To ensure comprehensive patient information access, the performance requirement specifies that the system loads all patient data efficiently, provides organized sections for different information categories, displays medical history in an accessible format, and shows consultation and appointment history. Under control, the doctor is given the ability to view complete patient demographics, access all medical history sections, review consultation history, view upcoming appointments, and initiate new consultations or appointments directly from the overview page.

---

## Table 18: Medical Condition Management

The table above outlines the Medical Condition Management function, which allows doctors to document and track patient medical conditions. The process begins with the input of condition details including condition name, ICD-10 code, diagnosis date, status, and clinical notes. Once the necessary data is provided, the system processes this information by adding or updating the patient's medical conditions list and storing the information in the medical record. The expected output is an updated medical conditions list with current and resolved conditions clearly indicated. To ensure accurate condition tracking, the performance requirement specifies that the system provides ICD-10 code search functionality, prevents duplicate condition entries, tracks condition status changes over time, and maintains a complete condition history. Under control, the doctor is given the ability to add new conditions, edit existing condition details, delete erroneous entries, mark conditions as resolved when appropriate, and search the ICD-10 database for accurate coding.

---

## Table 19: Medication Management

The table above outlines the Medication Management function, which allows doctors to maintain a current list of patient medications. The process begins with the input of medication details including medication name, dosage, frequency, start and end dates, prescribing doctor, and clinical notes. Once the necessary data is provided, the system processes this information by adding or updating the patient's current medications list and tracking medication history. The expected output is an updated current medications list showing active medications with all relevant details. To ensure medication safety and accuracy, the performance requirement specifies that the system checks for potential drug interactions, validates medication names against a database, tracks medication history including discontinued medications, and displays medication timelines. Under control, the doctor is given the ability to add new medications, edit medication details, delete incorrect entries, mark medications as discontinued when treatment ends, and view complete medication history.

---

## Table 20: Allergy Management

The table above outlines the Allergy Management function, which allows doctors to document patient allergies for safety during treatment. The process begins with the input of allergy details including allergen name, allergy type, reaction description, severity level, and clinical notes. Once the necessary data is provided, the system processes this information by adding or updating the patient's allergy list and displaying prominent allergy warnings throughout the system. The expected output is an updated allergy list with severity indicators and warnings displayed during prescription entry. To ensure patient safety, the performance requirement specifies that the system displays prominent allergy warnings during prescription entry, validates severity levels, highlights critical allergies with visual indicators, and maintains a complete allergy history. Under control, the doctor is given the ability to add new allergies, edit allergy details including severity levels, delete incorrect allergy entries, and view the complete allergy list with severity indicators prominently displayed.

---

## Table 21: Surgical History Management

The table above outlines the Surgical History Management function, which allows doctors to document patient surgical procedures and operations. The process begins with the input of surgical details including procedure name, surgery date, hospital or facility name, surgeon name, complications if any, and clinical notes. Once the necessary data is provided, the system processes this information by adding the surgical record to the patient's medical history and organizing procedures chronologically. The expected output is a chronological surgical history list displaying all past procedures with relevant details. To ensure comprehensive surgical history tracking, the performance requirement specifies that the system sorts procedures by date, provides a searchable database of common surgical procedures to speed up data entry, tracks complications and outcomes, and maintains a complete surgical timeline. Under control, the doctor is given the ability to add new surgical records, edit existing procedure details, delete incorrect entries, and view the complete surgical history organized chronologically.

---

## Table 22: Hospitalization History Management

The table above outlines the Hospitalization History Management function, which allows doctors to document patient hospital admissions and stays. The process begins with the input of hospitalization details including admission date, discharge date, hospital name, reason for admission, diagnosis, treatment received, and clinical notes. Once the necessary data is provided, the system processes this information by adding the hospitalization record to the patient's medical history and calculating the length of stay. The expected output is a chronological hospitalization history list showing all past admissions with dates, reasons, and outcomes. To ensure accurate hospitalization tracking, the performance requirement specifies that the system automatically calculates length of stay, sorts admissions by date, tracks readmissions to identify patterns, and maintains a complete hospitalization timeline. Under control, the doctor is given the ability to add new hospitalization records, edit existing admission details, delete incorrect entries, and view the complete hospitalization history with calculated stay durations.

---

## Table 23: Gynecological History Management

The table above outlines the Gynecological History Management function, which allows doctors to document gynecological and obstetric history for female patients. The process begins with the input of gynecological details including menarche age, last menstrual period, menstrual cycle length, pregnancy history with gravida and para counts, contraception methods, screening dates for PAP smears and mammograms, and clinical notes. Once the necessary data is provided, the system processes this information by storing the gynecological history in the patient's medical record and calculating relevant clinical indicators. The expected output is a complete gynecological history record with pregnancy history, menstrual information, and screening dates. To ensure appropriate gynecological care, the performance requirement specifies that the system calculates gestational age if the patient is pregnant, tracks screening dates and alerts for overdue screenings, validates obstetric history format, and maintains a complete gynecological timeline. Under control, the doctor is given the ability to add gynecological history, edit existing information, update pregnancy status, record screening dates, and view the complete gynecological record.

---

## Table 24: Lifestyle & Family History Management

The table above outlines the Lifestyle & Family History Management function, which allows doctors to document social determinants of health and hereditary risk factors. The process begins with the input of lifestyle details including smoking status with duration and quantity, alcohol use, drug use, diet and exercise habits, occupation, living situation, parents' health status, and family medical conditions. Once the necessary data is provided, the system processes this information by storing lifestyle and family history in the patient's medical record and identifying potential risk factors. The expected output is a comprehensive lifestyle and family history record highlighting hereditary conditions and behavioral risk factors. To ensure holistic patient care, the performance requirement specifies that the system tracks risk factors for preventive care planning, identifies hereditary conditions that may affect the patient, supports documentation of multiple family members' conditions, and maintains a complete social and family history. Under control, the doctor is given the ability to add lifestyle history, edit existing information, document family medical conditions, update behavioral risk factors, and view the complete lifestyle and family history record.

---

## Table 25: Consultation Summary Generation

The table above outlines the Consultation Summary Generation function, which allows doctors to create formatted consultation summaries after completing SOAP documentation. The process begins with the input of the consultation identifier. Once the necessary data is provided, the system processes this information by retrieving all consultation data including patient demographics, vital signs, symptoms, examination findings, diagnoses, prescriptions, and treatment plans, and formatting them into a professional summary document. The expected output is a comprehensive consultation summary available in both web view and PDF format, containing all SOAP components in a structured, readable layout. To ensure professional documentation, the performance requirement specifies that the system formats data into a clear, organized summary with proper medical terminology, includes all patient demographics and consultation details, generates high-quality PDF documents suitable for printing or electronic distribution, and maintains consistent formatting across all consultation summaries. Under control, the doctor is given the ability to view the consultation summary in web format, download the summary as a PDF document, print the summary for patient records, and share the summary with other healthcare providers or patients.

---

## Table 26: Appointment Calendar View

The table above outlines the Appointment Calendar View function, which allows doctors to visualize their appointment schedule in an interactive calendar format. The process begins with the input of date range selection, view type preferences for day, week, or month views, and filter criteria for appointment status. Once the necessary data is provided, the system processes this information by retrieving all appointments for the selected period, organizing them in a calendar layout, and applying color coding based on appointment status. The expected output is an interactive calendar displaying all appointments with visual indicators for status, appointment mode, and patient information. To ensure efficient schedule management, the performance requirement specifies that the system color-codes appointments by status for quick visual identification, displays appointment mode indicators for in-clinic versus telemedicine consultations, prevents overlapping bookings through real-time validation, and updates the calendar in real-time when appointments are added or modified. Under control, the doctor is given the ability to view the calendar in different time periods, filter appointments by status, click appointments to view details, and drag appointments to reschedule when supported.

---

## Table 27: Patient Dashboard

The table above outlines the Patient Dashboard function, which provides patients with a personalized overview of their healthcare information and quick access to system features. The process begins with the input of the patient's user identifier upon login. Once the necessary data is provided, the system processes this information by retrieving the patient's upcoming appointments, recent consultations, and relevant notifications, and displaying them in an organized dashboard layout. The expected output is a personalized dashboard showing appointment summaries, consultation history highlights, quick action buttons, and system navigation options. To ensure user-friendly patient access, the performance requirement specifies that the system displays appointment counts and next appointment details prominently, provides quick access to key features like booking appointments and viewing medical records, shows recent activity and notifications, and maintains a clean, intuitive interface. Under control, the patient is given the ability to view their dashboard overview, navigate to appointments section, access medical records, view prescriptions, and book new appointments through quick action buttons.

---

## Table 28: Patient Profile Management

The table above outlines the Patient Profile Management function, which allows patients to maintain and update their personal information through the patient portal. The process begins with the input of personal details including name, contact information, address, emergency contact details, and profile photo. Once the necessary data is provided, the system processes this information by updating the patient's profile record, validating email and phone number formats, and storing the updated information in the database. The expected output is an updated patient profile with current contact information and personal details. To ensure data accuracy and security, the performance requirement specifies that the system validates email and phone number formats, prevents duplicate email addresses across the system, updates profile information in real-time, and maintains a secure password change mechanism. Under control, the patient is given the ability to edit their personal profile information, change their password for account security, upload or update their profile photo, and view their complete profile as it appears in the system.

---

## Table 29: Appointment Booking (Patient)

The table above outlines the Appointment Booking function for patients, which allows them to request appointments with the doctor through the patient portal. The process begins with the input of appointment details including doctor selection, preferred date and time, appointment mode preference, urgency level, and reason for visit. Once the necessary data is provided, the system processes this information by checking doctor availability, creating an appointment request with pending status, and sending a confirmation notification to the patient. The expected output is an appointment request record with pending status awaiting doctor confirmation, along with a confirmation email sent to the patient. To ensure smooth appointment booking, the performance requirement specifies that the system shows only available time slots to prevent booking conflicts, validates that appointment dates are in the future, provides clear feedback on booking status, and sends automatic confirmation notifications via email. Under control, the patient is given the ability to select their preferred doctor, choose appointment date and time from available slots, specify appointment mode and urgency, provide reason for visit, and submit the appointment request.

---

## Table 30: View Appointments (Patient)

The table above outlines the View Appointments function for patients, which allows them to see all their scheduled and past appointments. The process begins with the input of the patient identifier and optional filter criteria for appointment status. Once the necessary data is provided, the system processes this information by retrieving all appointments associated with the patient, organizing them by date, and applying status filters if selected. The expected output is a list of appointments showing date, time, doctor name, status, appointment mode, and action buttons for managing appointments. To ensure clear appointment tracking, the performance requirement specifies that the system sorts appointments by date with upcoming appointments displayed first, provides filtering by status categories including upcoming, past, and cancelled appointments, shows appointment countdown for upcoming consultations, and displays clear status indicators. Under control, the patient is given the ability to view all their appointments, filter by status to focus on specific appointment types, view detailed appointment information, reschedule pending or confirmed appointments, and cancel appointments when necessary with a reason.

---

## Table 31: Appointment Rescheduling (Patient)

The table above outlines the Appointment Rescheduling function for patients, which allows them to request changes to their scheduled appointments. The process begins with the input of the appointment identifier, new preferred date and time, and reason for rescheduling. Once the necessary data is provided, the system processes this information by creating a reschedule request, checking doctor availability for the new time slot, and updating the appointment status to "reschedule requested" pending doctor approval. The expected output is a reschedule request record with pending approval status and a notification sent to the doctor. To ensure smooth rescheduling, the performance requirement specifies that the system validates the new date is in the future, checks doctor availability for the requested time slot, limits reschedule attempts to prevent abuse, and notifies the doctor of the reschedule request. Under control, the patient is given the ability to select a new date and time from available slots, provide a reason for rescheduling, submit the reschedule request, and view the request status.

---

## Table 32: Appointment Cancellation (Patient)

The table above outlines the Appointment Cancellation function for patients, which allows them to cancel scheduled appointments when necessary. The process begins with the input of the appointment identifier and cancellation reason. Once the necessary data is provided, the system processes this information by updating the appointment status to "cancelled," logging the cancellation reason, and sending a notification to the doctor. The expected output is a cancelled appointment record with the reason documented and a confirmation notification sent to the patient. To ensure proper cancellation tracking, the performance requirement specifies that the system updates appointment status immediately, sends cancellation notifications to the doctor, logs the cancellation reason for record-keeping, and provides confirmation feedback to the patient. Under control, the patient is given the ability to cancel pending or confirmed appointments, provide a reason for cancellation, confirm the cancellation action through a confirmation dialog, and receive cancellation confirmation.

---

## Table 33: View Medical Records (Patient)

The table above outlines the View Medical Records function for patients, which allows them to access their complete medical history through the patient portal. The process begins with the input of the patient identifier upon accessing the medical records section. Once the necessary data is provided, the system processes this information by retrieving all medical history components including conditions, medications, allergies, surgical history, hospitalization history, and lifestyle information, and displaying them in an organized, read-only format. The expected output is a comprehensive view of the patient's medical records organized by category with all historical information accessible. To ensure patient access to their health information, the performance requirement specifies that the system organizes records by category for easy navigation, displays information in chronological order, provides a read-only view to prevent accidental modifications, and maintains clear, understandable medical terminology. Under control, the patient is given the ability to view all medical record categories, navigate between different sections, and access their complete health history, but cannot edit or modify medical records as these are managed by healthcare providers.

---

## Table 34: View Prescriptions (Patient)

The table above outlines the View Prescriptions function for patients, which allows them to access all prescriptions issued during consultations. The process begins with the input of the patient identifier and optional filter criteria for prescription status. Once the necessary data is provided, the system processes this information by retrieving all prescriptions from completed consultations, organizing them by date, and displaying medication details including names, dosages, frequencies, and durations. The expected output is a list of prescriptions grouped by consultation date, showing all medication details and prescribing doctor information. To ensure clear prescription access, the performance requirement specifies that the system sorts prescriptions by date with most recent first, filters by active or completed status, displays complete medication information, and provides PDF download capability for each prescription. Under control, the patient is given the ability to view all their prescriptions, filter by status to see active or past medications, view detailed prescription information, and download prescription PDFs for pharmacy use or personal records.

---

## Table 35: View Consultation History (Patient)

The table above outlines the View Consultation History function for patients, which allows them to access their past consultation records and summaries. The process begins with the input of the patient identifier and optional date range filters. Once the necessary data is provided, the system processes this information by retrieving all completed consultations, organizing them chronologically, and displaying consultation summaries with diagnoses and treatment information. The expected output is a list of consultations showing dates, doctors, diagnoses, and action buttons for viewing full summaries or downloading PDFs. To ensure comprehensive consultation access, the performance requirement specifies that the system sorts consultations by date, provides search and filter functionality, enables quick access to consultation summaries, and allows PDF downloads for personal records. Under control, the patient is given the ability to view their complete consultation history, filter by date range to find specific consultations, access detailed consultation summaries, and download consultation PDFs for their records or to share with other healthcare providers.

---

## Table 36: View Consultation Summary (Patient)

The table above outlines the View Consultation Summary function for patients, which allows them to access detailed consultation summaries from their healthcare visits. The process begins with the input of the consultation identifier. Once the necessary data is provided, the system processes this information by retrieving the complete consultation record including all SOAP components, patient demographics, vital signs, symptoms, examination findings, diagnoses, prescriptions, and treatment plans, and displaying them in a formatted, read-only view. The expected output is a comprehensive consultation summary document showing all clinical information in a structured, easy-to-understand format. To ensure patient understanding and access, the performance requirement specifies that the system formats information for readability with clear section headings, includes all SOAP components in an organized layout, displays doctor's remarks and clinical notes, and provides PDF download capability for personal records. Under control, the patient is given the ability to view the complete consultation summary, read all clinical documentation including diagnoses and treatment plans, download the summary as a PDF document, and print the summary for their records or to share with other healthcare providers.

---

## Table 37: Notification Management (Patient)

The table above outlines the Notification Management function for patients, which allows them to view and manage system notifications regarding appointments and consultations. The process begins with the input of the patient identifier to retrieve all notifications. Once the necessary data is provided, the system processes this information by retrieving all notifications sent to the patient, organizing them by date with unread notifications displayed first, and showing notification details including type, message, and timestamp. The expected output is a list of notifications with read and unread status indicators, showing appointment confirmations, reminders, status updates, and consultation notifications. To ensure effective communication, the performance requirement specifies that the system delivers notifications in real-time via email, displays unread notification count with a badge indicator, organizes notifications chronologically, and maintains notification history for reference. Under control, the patient is given the ability to view all notifications in a centralized list, mark individual notifications as read to manage their inbox, and access notification details including appointment information and action items when applicable.

---

## ✅ **COMPLETION SUMMARY**

All 37 Requirements Modeling tables have been documented following the IPOPC (Input-Process-Output-Performance-Control) framework. Each table description provides a concise yet comprehensive explanation of system functions, maintaining consistency with the reference format while ensuring readability and professional academic tone.

**Total Tables Documented:** 37/37 (100%)
- **Doctor-Side Features:** Tables 1-26
- **Patient-Side Features:** Tables 27-37
- **System-Wide Features:** Integrated throughout

**Generated:** December 18, 2025

---

## 📝 **NOTES FOR THESIS DOCUMENTATION**

### **Current Implementation Status:**
- **Tables 1-37:** Fully documented and represent the implemented system (75.7% complete)
- **Tables 38-44:** Reserved for Phase 2 implementation (Billing & Reports modules)

### **For Thesis Chapter 4:**
Document Tables 1-37 as your Requirements Modeling section. These represent the core clinical workflows that are fully or substantially implemented in your system.

### **For Future Work Section:**
Reference Tables 38-44 (Billing & Reports) as planned enhancements for future development phases.

---

## 🔮 **PHASE 2 TABLES (Future Implementation)**

The following tables are planned for future implementation and are not part of the current thesis scope:

**Billing Module (Tables 38-40):**
- Table 38: Generate Billing Statement
- Table 39: Payment Recording  
- Table 40: Payment History Tracking

**Reports Module (Tables 41-44):**
- Table 41: Daily Consultation Log Report
- Table 42: Billing Summary Report
- Table 43: Prescription Report
- Table 44: Patient Records Report (Active/Inactive)

**Note:** Detailed specifications for these tables are available in the implementation roadmap document for Phase 2 development.

---

## ✅ **IMPLEMENTATION SUMMARY**

### **What's Included in Current System (Tables 1-37):**

**Doctor-Side Features (Tables 1-26):**
- ✅ User Management
- ✅ Patient Registration & Management
- ✅ Complete Medical History Documentation
- ✅ Appointment Management
- ✅ Full SOAP Consultation Workflow
- ✅ Prescription Management
- ✅ Consultation History & Summaries
- ✅ Audit Logging & Notifications

**Patient-Side Features (Tables 27-37):**
- ✅ Patient Dashboard & Profile
- ✅ Appointment Booking & Management
- ✅ View Medical Records (Read-only)
- ✅ View Prescriptions
- ✅ View Consultation History
- ✅ Notification Management

### **What's Planned for Phase 2 (Tables 38-44):**

**Billing Module:**
- Generate billing statements
- Record payments
- Track payment history

**Reports Module:**
- Daily consultation logs
- Billing summaries
- Prescription reports
- Patient records reports

---

## 🎓 **FOR YOUR THESIS**

### **Chapter 4 - Requirements Modeling:**
Use Tables 1-37 as your complete Requirements Modeling section. These represent 75.7% implementation of your system scope.

### **Chapter 5 - Future Work/Recommendations:**
Reference Tables 38-44 as planned enhancements:
> "The system currently focuses on core clinical workflows including patient management, appointments, consultations, and prescriptions. Future enhancements identified include comprehensive billing and payment processing (Tables 38-40) and advanced reporting capabilities (Tables 41-44) to support financial management and analytics."

---

## 💰 **BILLING & PAYMENT MODULE (Tables 38-40)**

### **Table 38: Generate Billing Statement**

The table above outlines the Generate Billing Statement function, which allows doctors or administrators to create billing records for patient consultations. The process begins with the input of billing details including Patient ID, Consultation ID, Consultation Fee, Additional Charges if any, and calculated Total Amount. Once the necessary data is provided, the system processes this information by generating a billing statement with itemized charges and assigning a unique billing number. The expected output is a billing statement document showing all charges, total amount, and payment status. To ensure accurate billing, the performance requirement specifies that the system calculates totals automatically, validates fee amounts, prevents duplicate billing for the same consultation, and maintains billing history. Under control, the user is given the ability to generate new billing statements, view existing bills, edit billing details before finalization, and void incorrect billing records.

---

### **Table 39: Payment Recording**

The table above outlines the Payment Recording function, which allows staff to record payments received from patients. The process begins with the input of payment details including Billing ID, Payment Date, Amount Paid, Payment Method (Cash/Bank Transfer/Card/GCash), and Reference Number if applicable. Once the necessary data is provided, the system processes this information by recording the payment transaction, updating the billing status, and calculating any outstanding balance. The expected output is a payment receipt and updated billing record showing payment status (Paid/Partial/Unpaid). To ensure accurate payment tracking, the performance requirement specifies that the system validates payment amounts against billing totals, updates outstanding balances automatically, tracks complete payment history, and generates receipt numbers. Under control, the user is given the ability to record new payments, view payment receipts, print receipts for patients, and track payment history.

---

### **Table 40: Payment History Tracking**

The table above outlines the Payment History Tracking function, which allows doctors and patients to view complete payment transaction history. The process begins with the input of Patient ID and optional Date Range Filter. Once the necessary data is provided, the system processes this information by retrieving all payment transactions for the patient and organizing them chronologically. The expected output is a list of payments showing dates, amounts, payment methods, billing details, and outstanding balances. To ensure comprehensive payment tracking, the performance requirement specifies that the system sorts payments by date, calculates total amounts paid, shows outstanding balances clearly, and provides payment status indicators. Under control, the user is given the ability to view complete payment history, filter by date range to find specific transactions, download payment statements, and track outstanding balances.

---

## 📊 **REPORTS MODULE (Tables 41-44)**

### **Table 41: Daily Consultation Log Report**

The table above outlines the Daily Consultation Log Report function, which allows doctors to generate reports of all consultations within a selected period. The process begins with the input of Date or Date Range selection. Once the necessary data is provided, the system processes this information by retrieving all consultations within the specified period and organizing them with patient names, diagnoses, and timestamps. The expected output is a comprehensive consultation log report with summary statistics including total consultations, patient count, and common diagnoses. To ensure useful reporting, the performance requirement specifies that the system exports reports to PDF format, sorts consultations chronologically, includes summary statistics for analysis, and provides filtering options. Under control, the user is given the ability to generate reports for specific periods, view reports on screen, download PDF versions, and print reports for record-keeping.

---

### **Table 42: Billing Summary Report**

The table above outlines the Billing Summary Report function, which allows doctors to generate financial reports of all billing transactions. The process begins with the input of Date Range and Status Filter (Paid/Unpaid/Partial). Once the necessary data is provided, the system processes this information by retrieving all billing records within the period and calculating financial summaries. The expected output is a financial report showing total revenue, outstanding payments, collection rate, and payment method breakdown. To ensure comprehensive financial reporting, the performance requirement specifies that the system calculates totals automatically, groups transactions by status, shows payment trends over time, and provides export capabilities. Under control, the user is given the ability to generate financial reports, view revenue summaries, download PDF reports, and export data to Excel for further analysis.

---

### **Table 43: Prescription Report**

The table above outlines the Prescription Report function, which allows doctors to generate reports of all issued prescriptions. The process begins with the input of Date Range and optional Medicine Name Filter. Once the necessary data is provided, the system processes this information by retrieving all prescriptions within the period and organizing them with patient names, medications, and dates. The expected output is a prescription report showing all issued prescriptions with medication details and prescription counts. To ensure useful prescription tracking, the performance requirement specifies that the system sorts prescriptions by date, filters by specific medicines when needed, shows prescription frequency statistics, and provides export capabilities. Under control, the user is given the ability to generate prescription reports, view medication usage patterns, download PDF reports, and print reports for inventory or analysis purposes.

---

### **Table 44: Patient Records Report (Active/Inactive)**

The table above outlines the Patient Records Report function, which allows doctors to generate lists of patient records by status. The process begins with the input of Status Filter (Active/Archived) and optional Date Range. Once the necessary data is provided, the system processes this information by retrieving patient records matching the criteria and organizing them with registration dates, last visit dates, and status indicators. The expected output is a patient list report showing all patients with their activity status and visit history. To ensure comprehensive patient tracking, the performance requirement specifies that the system counts active versus inactive patients, sorts by various criteria including last visit date, provides patient statistics, and supports export functionality. Under control, the user is given the ability to generate patient reports, view patient statistics, filter by activity status, download PDF reports for record-keeping or analysis.

---

## ✅ **COMPLETE REQUIREMENTS MODELING SUMMARY**

**Total Tables Documented:** 44/44 (100%)

**Currently Implemented (Tables 1-37):**
- User Management & Authentication
- Patient Registration & Medical History
- Appointment Management (Doctor & Patient)
- Complete SOAP Consultation Workflow
- Prescription Management
- Consultation History & Summaries
- Notification System & Audit Logging
- Patient Portal Features

**Planned for Implementation (Tables 38-44):**
- Billing & Payment Module (Tables 38-40)
- Reports & Analytics Module (Tables 41-44)

---

**End of Requirements Modeling Documentation**
**Generated:** December 18, 2025

"Billing Module:
Table 38: Generate Billing Statement
CategoryDetailsUserDoctor/AdminInputPatient ID, Consultation ID, Consultation Fee, Additional Charges, Total AmountProcessGenerate billing statement based on consultation and feesOutputBilling statement with itemized chargesPerformanceCalculates total automatically, validates fee amounts, prevents duplicate billingControlGenerate, View, Edit, Void

Table 39: Payment Recording
CategoryDetailsUserDoctor/AdminInputBilling ID, Payment Date, Amount Paid, Payment Method (Cash/Bank Transfer), Reference NumberProcessRecord payment and update billing statusOutputPayment receipt, updated billing statusPerformanceValidates payment amount, updates outstanding balance, tracks payment historyControlRecord Payment, View Receipt, Print Receipt

Table 40: Payment History Tracking
CategoryDetailsUserDoctor/PatientInputPatient ID, Date Range FilterProcessRetrieve all payment transactions for patientOutputList of payments with dates, amounts, and billing detailsPerformanceSorts by date, calculates total paid, shows outstanding balanceControlView, Filter by Date, Download Statement

Reports Module:
Table 41: Daily Consultation Log Report
CategoryDetailsUserDoctorInputDate or Date RangeProcessGenerate report of all consultations within selected periodOutputList of consultations with patient names, diagnoses, and timestampsPerformanceExports to PDF, sorts chronologically, includes summary statisticsControlGenerate, View, Download PDF, Print

Table 42: Billing Summary Report
CategoryDetailsUserDoctorInputDate Range, Status Filter (Paid/Unpaid/Partial)ProcessGenerate financial report of all billing transactionsOutputSummary of revenue, outstanding payments, and collection ratePerformanceCalculates totals, groups by status, shows payment trendsControlGenerate, View, Download PDF, Export to Excel

Table 43: Prescription Report
CategoryDetailsUserDoctorInputDate Range, Medicine Name Filter (Optional)ProcessGenerate list of all issued prescriptionsOutputList of prescriptions with patient names, medications, and datesPerformanceSorts by date, filters by medicine, shows prescription countControlGenerate, View, Download PDF, Print

Table 44: Patient Records Report (Active/Inactive)
CategoryDetailsUserDoctorInputStatus Filter (Active/Archived), Date RangeProcessGenerate list of patient records by statusOutputPatient list with registration dates, last visit dates, and statusPerformanceCounts active vs inactive patients, sorts by various criteriaControlGenerate, View, Filter, Download PDF"