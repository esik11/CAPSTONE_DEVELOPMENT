# Consultation Symptoms Sub-Module - Implementation Tasks

## Phase 1: Database Foundation

- [x] 1. Update consultations table migration

  - Add all symptom-related fields (selected_complaints, template_responses, etc.)
  - Add indexes for performance
  - _Requirements: 1.1, 2.1, 3.1, 4.1_









- [x] 2. Create complaint_templates table migration

  - Create table structure
  - Add indexes


  - _Requirements: 4.1_


- [ ] 3. Create visit_type_templates table migration
  - Create table structure

  - _Requirements: 3.1_









- [ ] 4. Update Consultation model
  - Add fillable fields
  - Add casts for JSON fields
  - Add relationships (patient, doctor, appointment)







  - _Requirements: 1.1_

- [ ] 5. Create ComplaintTemplate model
  - Add fillable fields
  - Add casts
  - Add scopes (adult, pediatric)
  - _Requirements: 4.1_

- [ ] 6. Create VisitTypeTemplate model
  - Add fillable fields
  - Add casts
  - _Requirements: 3.1_

## Phase 2: Seeders for Templates

- [ ] 7. Create ComplaintTemplateSeeder
  - Seed adult medicine complaints (Abdominal Pain, Anxiety, Back pain, etc.)
  - Seed pediatric complaints (Fever, Cough, Rash, etc.)
  - Include template questions JSON structure
  - Include output templates
  - _Requirements: 2.1, 4.1_

- [ ] 8. Create VisitTypeTemplateSeeder
  - Seed visit types (COVID-19, Chronic follow-up, General checkup, etc.)
  - Include template questions
  - _Requirements: 3.1_

## Phase 3: Backend Services

- [ ] 9. Create TemplateService
  - Implement getComplaintTemplate() method
  - Implement mergeTemplates() method for multiple complaints
  - Implement generateNotes() method for auto-generation
  - Implement getVisitTypeTemplate() method
  - _Requirements: 4.1, 15.1_

- [ ] 10. Create ConsultationController
  - Implement start() method - create/resume consultation
  - Implement show() method - display consultation
  - Implement saveDraft() method
  - Implement continue() method - validate and move to next section
  - Add authorization checks
  - _Requirements: 1.1, 11.1, 14.1, 16.1_

- [ ] 11. Add consultation routes
  - GET /patients/{patient}/consultation/start
  - GET /consultations/{consultation}
  - POST /consultations/{consultation}/save-draft
  - POST /consultations/{consultation}/continue
  - _Requirements: 1.1_

## Phase 4: Livewire Components

- [ ] 12. Create ConsultationSymptomsForm Livewire component
  - Add properties (selectedComplaints, templateResponses, etc.)
  - Implement selectComplaint() method
  - Implement selectVisitType() method
  - Implement updateTemplateResponse() method
  - Implement auto-save functionality (wire:poll.30s)
  - Implement generateNotes() method
  - Implement saveDraft() method
  - Implement continueToExamination() method with validation
  - _Requirements: 2.1, 3.1, 4.1, 5.1, 10.1, 14.1, 15.1, 16.1_

- [ ] 13. Create PatientSidebarComponent Livewire component
  - Display patient demographics
  - Display latest vitals
  - Display active conditions
  - Display active medications
  - Display allergies
  - Display recent consultations (last 5)
  - Implement quick-add buttons
  - Listen for update events
  - _Requirements: 12.1, 13.1_

## Phase 5: Views and UI

- [ ] 14. Create consultation layout blade template
  - Header with patient info and action buttons
  - Split-screen layout (70/30)
  - Tab navigation (Symptoms, Examination, Diagnosis, Plan)
  - Auto-save indicator
  - _Requirements: 1.1, 10.1, 16.1_

- [ ] 15. Create symptoms form view
  - Complaint buttons grid (adult & pediatric)
  - Visit type buttons grid
  - Dynamic template questions section
  - Symptom notes editor (auto-generated + manual)
  - Continue button
  - _Requirements: 2.1, 3.1, 4.1, 5.1, 15.1_

- [ ] 16. Create patient sidebar view
  - Demographics card
  - Latest vitals card
  - Conditions widget with quick-add
  - Medications widget with quick-add
  - Allergies widget with quick-add
  - Recent consultations list
  - _Requirements: 12.1, 13.1_

- [ ] 17. Style complaint and visit type buttons
  - Clickable button design
  - Selected state styling
  - Hover effects
  - Responsive grid layout
  - _Requirements: 2.1, 3.1_

- [ ] 18. Create template question components
  - Checkbox component
  - Radio button component
  - Text input component
  - Number input component
  - Dropdown component
  - _Requirements: 4.1_

## Phase 6: Real-Time Features

- [ ] 19. Implement real-time note generation
  - Watch templateResponses for changes
  - Call TemplateService to generate notes
  - Update symptom_notes_auto in real-time
  - Display in editable text area
  - _Requirements: 15.1_

- [ ] 20. Implement auto-save with visual indicator
  - Use Livewire polling (30 seconds)
  - Show "Saving..." indicator
  - Show "Saved at [time]" indicator
  - Handle save failures with retry
  - _Requirements: 10.1_

- [ ] 21. Implement quick actions integration
  - Dispatch events to open modals
  - Listen for item-added events
  - Refresh sidebar data
  - Maintain scroll position
  - _Requirements: 13.1_

## Phase 7: Validation and Error Handling

- [ ] 22. Add validation rules
  - Require complaint OR manual notes
  - Validate template responses
  - Validate before continuing to examination
  - _Requirements: 14.1_

- [ ] 23. Implement error handling
  - Display validation errors
  - Handle auto-save failures
  - Handle template loading failures
  - Fallback to free-text mode on errors
  - _Requirements: 14.1_

## Phase 8: Integration and Polish

- [ ] 24. Update patient overview page
  - Add "Start Consult" button
  - Check for existing draft consultations
  - Show "Resume Consultation" if draft exists
  - _Requirements: 1.1, 11.1_

- [ ] 25. Implement draft consultation resume
  - Load existing consultation data
  - Populate form with saved data
  - Show warning if draft is old (>24 hours)
  - _Requirements: 11.1_

- [ ] 26. Add consultation authorization
  - Create ConsultationPolicy
  - Verify doctor can access patient
  - Verify doctor owns consultation
  - _Requirements: 1.1_

- [ ] 27. Implement audit logging
  - Log consultation creation
  - Log draft saves
  - Log section completion
  - _Requirements: 10.1_

## Phase 9: Testing

- [ ] 28. Write unit tests
  - TemplateService::generateNotes()
  - TemplateService::mergeTemplates()
  - Consultation model methods
  - _Requirements: All_

- [ ] 29. Write feature tests
  - Start consultation flow
  - Save draft functionality
  - Continue to examination
  - Template selection
  - _Requirements: All_

- [ ] 30. Write browser tests (Dusk)
  - Complete symptom documentation workflow
  - Select complaints and answer questions
  - Verify real-time note generation
  - Test quick actions
  - Test auto-save
  - _Requirements: All_

## Phase 10: Documentation and Deployment

- [ ] 31. Create user documentation
  - How to start a consultation
  - How to use complaint templates
  - How to use free-text mode
  - How to use quick actions
  - _Requirements: All_

- [ ] 32. Run migrations
  - Run all new migrations
  - Seed complaint templates
  - Seed visit type templates
  - _Requirements: All_

- [ ] 33. Clear caches
  - Clear view cache
  - Clear route cache
  - Clear config cache
  - _Requirements: All_

## Checkpoint

- [ ] 34. Final testing and review
  - Test complete workflow end-to-end
  - Verify auto-save works correctly
  - Verify real-time note generation
  - Verify quick actions work
  - Verify validation works
  - Get user feedback
  - _Requirements: All_

---

## Notes

- Each task should be completed and tested before moving to the next
- Auto-save functionality is critical - test thoroughly
- Real-time note generation is the key feature - ensure it works smoothly
- Template seeding is important - include comprehensive complaint list
- Quick actions should work seamlessly without page reload
