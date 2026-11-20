<?php
/**
 * Terms & Conditions ka content.
 * Jo clauses purane site ke screenshots me poore nahi dikhe, unki jagah TODO likha hai
 * (5, 8.03-8.05, 11, 13, Schedule of Payment ka last hissa, aur signature block).
 */
return [

    ['n' => 1, 'title' => 'Scope of Work',
     'intro' => 'The Architect shall be required to provide services in respect of the following:',
     'items' => [
        ['1.1',  'Site evaluation and assessment.'],
        ['1.2',  'space planning / development & volumetric study.'],
        ['1.3',  'Architectural additions and alterations.'],
        ['1.4',  'Design of fixed items of work, loose furniture & interior related civil works.'],
        ['1.5',  'Illumination design.'],
        ['1.6',  'Sound and acoustic design.'],
        ['1.7',  'Graphic design and signage.'],
        ['1.8',  'Indoor landscape.'],
        ['1.9',  'Selection of materials, equipment and other interior related elements.'],
        ['1.10', 'Integration of all Engineering services.'],
        ['1.11', 'Periodic inspection and evaluation of works at site.'],
     ]],

    ['n' => 2, 'title' => 'Schedule of Services',
     'intro' => 'The Architect shall, after taking instructions from the Client, render the following services:',
     'groups' => [
        ['stage' => 'Stage 1', 'name' => 'Concept Design', 'items' => [
            ['2.01', 'Site evaluation and analysis with basic approach to circulation, activity distribution, interaction and external linkages.'],
            ['2.02', 'Analyze schedule of spaces in relation to activities and site potential.'],
            ['2.03', 'Prepare conceptual designs with reference to requirements.'],
        ]],
        ['stage' => 'Stage 2', 'name' => 'Preliminary Design', 'items' => [
            ['2.04', 'Modify the conceptual designs incorporating required changes; prepare the preliminary drawings and schedule of finishes for the Client’s approval along with the preliminary estimate of cost on area basis.'],
        ]],
        ['stage' => 'Stage 3', 'name' => 'Drawings for Clients / Statutory Approval', 'items' => [
            ['2.05', 'Prepare drawings necessary for Client’s / statutory approvals and ensure compliance with codes & standards as applicable.'],
        ]],
        ['stage' => 'Stage 4', 'name' => 'Working Drawings and Tender Documents', 'items' => [
            ['2.06', 'Prepare working drawings, specifications and schedule of quantities sufficient to prepare estimate of cost and tender documents including code of practice covering aspects like mode of measurement, method of payments, quality control procedures on materials & works and other conditions of contract.'],
        ]],
        ['stage' => 'Stage 5', 'name' => 'Appointment of Contractors', 'items' => [
            ['2.07', 'Invite, receive and analyze tenders, advise Client on appointment of contractors.'],
        ]],
        ['stage' => 'Stage 6', 'name' => 'Construction', 'items' => [
            ['2.08', 'Prepare and issue working drawings and details for proper execution of works during construction.'],
            ['2.09', 'Approve samples of various elements and components.'],
            ['2.10', 'Check and approve shop drawings submitted by the contractor / vendors.'],
            ['2.11', 'Visit the site of work and fabrication workshop, at intervals mutually agreed upon, to inspect and evaluate the progress of works and where necessary clarify and take decisions, offer interpretation of the drawings / specifications, attend conferences and meetings to ensure that the project proceeds generally in accordance with the conditions of the contract and keep the Client informed and render advice on actions, if required.'],
            ['2.12', 'In order to ensure that the work at site proceeds in accordance with the contract documents / drawings and to exercise time and quality controls, the day-to-day supervision will be carried out by a Construction manager (Clerk of Works / Site Supervisor or Construction Management Agency in case of a large and complex project), who shall work under the guidance and direction of the Architect and shall be appointed and paid by the Client.'],
            ['2.13', 'Issue Certificate of Virtual Completion of works.'],
        ]],
        ['stage' => 'Stage 7', 'name' => 'Completion', 'items' => [
            ['2.14', 'Prepare and submit completion report and drawings for the project as required.'],
            ['2.15', 'Issue two sets of as build drawings including service and structures.'],
        ]],
     ]],

    ['n' => 3, 'title' => 'Professional Fee',
     'items' => [
        ['3.01', 'In consideration of the professional services rendered by the Architect, he shall be paid professional fee and other charges in accordance with the Scale of Charges.'],
        ['3.02', 'Any tax levied by law, such as Service Tax, etc. contingent to professional services rendered by the Architect, shall be payable by the Client, over and above the gross fees charged by the Architect in relation to the services provided.'],
     ]],

    ['n' => 4, 'title' => 'Schedule of Payment',
     'intro' => 'The Architect shall be paid professional fee in the following stages consistent with the work done plus other charges and reimbursable expenses as agreed upon.',
     'payments' => [
        // [label, "On ..." text, fee text, badge]
        ['Retainer', 'On appointment / Signing of Agreement / Acceptance of offer.', 'Rs. 25,000/- or 5% of the total fees payable, whichever is higher, adjustable at the last stage.', '5%'],
        ['Stage 1',  'On submitting conceptual designs and rough estimates of cost.', '10% of the total fees payable.', '10%'],
        ['Stage 2',  'On submitting the required preliminary scheme for the Client’s approval along with the preliminary estimate of cost.', '20% of the total fees payable less payment already made at stage 1.', '20%'],
        ['Stage 3',  'On incorporating Clients suggestions and submitting drawings for approval from the Client, statutory authorities, if required.', '35% of the total fees payable less payment already made at Stages 1 and 2.', '35%'],
        ['Stage 4',  'Upon Client’s approval/ statutory approvals and preparation of working drawings, specifications and schedule of quantities sufficient to prepare estimate of cost and preparation of tender documents.', '45% of the total fees payable less payment already made at Stages 1 to 3.', '45%'],
        ['Stage 5',  'On inviting, receiving and analyzing tender; advising Client on appointment of contractrors.', '55% of the total fees payable less payment already made at stages 1 to 4.', '55%'],
        ['Stage 6a', 'On submitting working drawings and details required for commencement of work at site.', '65% of the total fees payable less payment already made at Stages 1 to 5.', '65%'],
        ['Stage 6b (i)',   'On completion of 20% of the work.', '70% of the total fees payable less payment already made at Stages 1 to 6a.', '70%'],
        ['Stage 6b (ii)',  'On completion of 40% of the work.', '75% of the total fees payable less payment already made at Stages 1 to 6b(i).', '75%'],
        ['Stage 6b (iii)', 'On completion of 60% of the work.', '80% of the total fees payable less payment already made at Stages 1 to 6b(ii).', '80%'],
        // TODO: Stage 6b (iv) onwards aur Stage 7 ki payment lines (screenshot me kat gayi thi).
     ]],

    // TODO: Clause 5 (screenshot me nahi dikha).

    ['n' => 6, 'title' => 'Reimbursable Expenses',
     'intro' => 'In addition to the amounts reimbursable against site visits by the Architect / Consultant, the Client will reimburse the Architect the following expenses incurred by him for discharge of his obligations:',
     'items' => [
        ['6.01', 'Actual cost of travel (to & fro), boarding & lodging and local transport for any visit made by his staff to the site or such other place as may be necessary in connection with the execution of work and in connection with the performance of duties referred to in this agreement.'],
        ['6.02', 'Cost of presentation models, computer simulation, presentation drawings, etc., prepared at the instance of the Client for purposes other than the Design and execution of the project.'],
     ]],

    ['n' => 7, 'title' => 'Clients Role and Responsibilities',
     'intro' => 'The Client shall discharge all his obligations connected with the project and engagement of the Architect as follows:',
     'items' => [
        ['7.01', 'To provide detailed requirements of the project.'],
        ['7.02', 'To provide property lease / ownership documents.'],
        ['7.03', 'To provide location plan, measured drawings and photographs of existing space with full structural and relevant details, existing services and common outlets to which proposed services can be connected. In case such information is not readily available, the Client shall arrange for the collection of necessary information and pay for the same.'],
        ['7.04', 'To furnish specific conditions / statutory stipulations / codes of practice / schedule of rates, etc. desired to be followed.'],
        ['7.05', 'To pay all the fees, levies, security deposits and expenses in respect of statutory sanctions.'],
        ['7.06', 'To give effect to the professional advice of the Architect and cause no changes in the drawings and documents without the consent of the Architect.'],
        ['7.07', 'To honor Architect’s bills within 15 days of its submission.'],
        ['7.08', 'To appoint a Construction Manager (Clerk of Works / Site Supervisor or Construction Management Agency in case of a large and complex project) as per the Architect’s advice.'],
     ]],

    ['n' => 8, 'title' => 'Execution of the Assignment',
     'items' => [
        ['8.01', 'The Architect shall keep the Client informed about the progress of work in his office.'],
        ['8.02', 'The Architect shall appoint specialized consultants in consultation with the Client, if necessary.'],
        // TODO: 8.03, 8.04, 8.05 (screenshot me nahi dikhe).
        ['8.06', 'The Architect shall not make any deviations, alterations or omissions from the approved drawings, involving financial implications without prior consent of the Client.'],
        ['8.07', 'Any professional services to be rendered by the Architect at the instance of the Client after the agreed project completion period shall be compensated for on mutually agreed terms.'],
        ['8.08', 'The Architect shall exercise all reasonable skill, care and diligence in the discharge of his duties and shall exercise such general superintendence and inspection as may be necessary to ensure that works are being executed in accordance with the Conditions of Contract.'],
        ['8.09', 'Any revision in the drawings, tenders and documents, once approved required to be made by the Client shall be compensated as additional services rendered by the Architect and paid for @ 50% of the fee prescribed for the relevant stages.'],
        ['8.10', 'No change shall be made in the approved drawings and specifications at site without the consent of the Architect.'],
        ['8.11', 'Any curtailment of the professional services, beyond Stage 2, shall make it obligatory for the client to pay at least 20% of the fee for the remaining stages of the curtailed work /Services.'],
     ]],

    ['n' => 9, 'title' => 'Time Schedule',
     'intro' => 'The Architect shall, in consultation with the Client, prepare Time Schedule in respect of various services to be rendered and discharge of Client’s obligations.'],

    ['n' => 10, 'title' => 'Indemnification',
     'intro' => 'In the event that a claim or suit is brought against the Architect or the Consultants by any third party for damages arising from personal injury or property damage caused wholly by the Client, or anyone employed by the Client, or anyone for whose acts the Client may be held responsible, then the client shall indemnify the Architect and fully reimburse any loss, damage or expenses, including the attorney’s fees, which the Architect may incur in connection therewith.'],

    // TODO: Clause 11 (screenshot me nahi dikha).

    ['n' => 12, 'title' => 'Termination of Agreement',
     'items' => [
        ['12.1', 'Agreement between the Architect and the Client may be terminated by either one giving the other a written notice of not less than 30 (thirty) days, should either fail substantially to perform his part of responsibilities / duties, so long as the failure is not caused by the one initiating the termination.'],
        ['12.2', 'When termination of this Agreement is not related or attributable, directly or indirectly to any act, omission, neglect or default on the part of the Architect, the Architect shall be entitled to professional fees as stipulated under Clause 4 and sub-clauses 8.09 and 8.11 of Clause of 8.'],
        ['12.3', 'In the event of Architect’s firm closing its business or the Client having terminated the agreement, the Client shall have the right to employ another Architect to complete the work, after making payment to the previous architect’s firm.'],
     ]],

    // TODO: Clause 13 (screenshot me nahi dikha).

    ['n' => 14, 'title' => 'Interpretation',
     'intro' => 'In case of any ambiguity of difficulty in interpretation of the Conditions of Engagement and Scale of Charges, the interpretation of the Council of Architecture shall be final and binding on the Architect and the Client.'],

    ['n' => 15, 'title' => 'Arbitration',
     'intro' => 'All disputes or differences which may arise between the Client and the Architect under “Conditions of Engagement and Scale of Charges” with regard to the meaning or interpretation or matter of things done or to be done in pursuance hereof, such disputes and differences shall be referred for arbitration to the Council of Architecture. The arbitrator shall be appointed by the President, Council of Architecture. The arbitration shall be conducted as per the provisions of the Arbitration and Conciliation Act, 1996. The decision and award of the arbitrator shall be final and binding on the Architect and the Client.'],
];
