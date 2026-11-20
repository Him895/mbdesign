<?php
$pageTitle = 'Quotation & Agreement';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';
?>

<style>
.qa-wrap { max-width: 900px; margin: 0 auto; padding: 60px 20px 80px; }

/* Letterhead */
.qa-letterhead {
  width: 100%;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(60,45,10,.12);
  margin-bottom: 50px;
}
.qa-letterhead img { width: 100%; display: block; }

/* Section heading */
.qa-heading {
  font-family: var(--h);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  text-align: center;
  letter-spacing: 2px;
  color: var(--ink);
  margin: 50px 0 30px;
  font-weight: 700;
}
.qa-heading::after {
  content: "";
  display: block;
  width: 70px;
  height: 3px;
  background: var(--gold);
  margin: 18px auto 0;
}

/* Offer letter body */
.qa-body {
  font-family: var(--body, 'Inter', sans-serif);
  font-size: 1.05rem;
  line-height: 1.75;
  color: #3a3a3a;
  background: #fff;
  padding: 50px 55px;
  border-radius: 14px;
  box-shadow: 0 10px 40px rgba(0,0,0,.06);
  margin-bottom: 50px;
}
.qa-body .to-line {
  margin-bottom: 28px;
  font-weight: 500;
}
.qa-body .to-line span {
  display: block;
  border-bottom: 1.5px dotted #999;
  height: 22px;
  margin-top: 4px;
}
.qa-body .subject {
  margin: 26px 0;
  font-weight: 600;
  color: var(--ink);
}
.qa-body .subject u { text-decoration: underline; }
.qa-body p { margin: 14px 0; }
.qa-body .greet { font-weight: 600; margin-top: 28px; }

/* Table */
.qa-table {
  width: 100%;
  border-collapse: collapse;
  margin: 30px 0;
  font-size: .98rem;
}
.qa-table th, .qa-table td {
  border: 1.5px solid #2a2a2a;
  padding: 14px 16px;
  text-align: left;
}
.qa-table th {
  background: var(--ink);
  color: #fff;
  font-family: var(--h);
  font-size: 1.05rem;
  letter-spacing: 1px;
  text-align: center;
}
.qa-table td:last-child {
  text-align: right;
  font-family: var(--h);
  white-space: nowrap;
}
.qa-table tbody tr:nth-child(even) { background: #faf7ef; }

/* Thank you */
.qa-thanks {
  margin: 30px 0 50px;
  font-style: italic;
  color: #555;
}

/* Signatures */
.qa-signs {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  margin: 50px 0;
  padding-top: 30px;
}
.qa-sign {
  text-align: center;
  font-family: var(--h);
  font-weight: 700;
  letter-spacing: 1.5px;
  color: var(--ink);
  padding-top: 70px;
  border-top: 2px solid var(--gold);
  font-size: 1.05rem;
}

/* Services banner */
.qa-banner {
  width: 100%;
  border-radius: 14px;
  overflow: hidden;
  margin: 40px 0;
  box-shadow: 0 15px 40px rgba(60,45,10,.15);
}
.qa-banner img { width: 100%; display: block; }

/* Date line */
.qa-date {
  text-align: right;
  font-family: var(--h);
  font-size: 1.1rem;
  color: var(--ink);
  margin: 40px 0 30px;
  letter-spacing: 1px;
}

/* Agreement block */
.qa-agreement {
  background: #fff;
  padding: 50px 55px;
  border-radius: 14px;
  box-shadow: 0 10px 40px rgba(0,0,0,.06);
  margin-bottom: 50px;
}
.qa-agreement h3 {
  font-family: var(--h);
  font-size: 1.5rem;
  text-align: center;
  margin-bottom: 8px;
  color: var(--ink);
}
.qa-agreement h4 {
  font-family: var(--h);
  font-size: 1.15rem;
  text-align: center;
  color: var(--gold-d);
  margin-bottom: 24px;
  font-weight: 600;
}
.qa-agreement .intro {
  font-style: italic;
  color: #555;
  margin-bottom: 24px;
  line-height: 1.7;
}
.qa-agreement .between {
  text-align: center;
  font-family: var(--h);
  font-weight: 700;
  letter-spacing: 3px;
  margin: 30px 0 18px;
  color: var(--ink);
}
.qa-agreement .party {
  margin: 18px 0;
  line-height: 1.7;
}
.qa-agreement .party b {
  font-family: var(--h);
  color: var(--ink);
  font-size: 1.1rem;
}
.qa-agreement .party .role {
  color: var(--gold-d);
  font-weight: 600;
  margin-bottom: 6px;
}

/* Print button */
.qa-print {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  margin-top: 20px;
  padding: 14px 32px;
  background: var(--ink);
  color: #fff;
  border: none;
  border-radius: 50px;
  font-family: var(--h);
  font-size: 1rem;
  letter-spacing: 1px;
  cursor: pointer;
  transition: .3s;
}
.qa-print:hover { background: var(--gold-d); transform: translateY(-2px); }

@media print {
  .qa-print, header, footer, .page-header { display: none !important; }
  .qa-body, .qa-agreement { box-shadow: none; padding: 30px; }
  .qa-letterhead, .qa-banner { box-shadow: none; }
}

@media (max-width: 700px) {
  .qa-body, .qa-agreement { padding: 28px 22px; }
  .qa-signs { grid-template-columns: 1fr; gap: 24px; }
  .qa-table th, .qa-table td { padding: 10px 8px; font-size: .88rem; }
}
</style>

<main>
<section class="section">
  <div class="qa-wrap">

    <!-- Letterhead 1 -->
    <div class="qa-letterhead reveal">
      <img src="assets/img/quotation/letterhead-top.png" alt="MB Design & Build Letterhead" onerror="this.parentElement.style.background='linear-gradient(135deg,var(--gold-d),var(--ink))';this.parentElement.style.height='160px';">
    </div>

    <!-- Offer Letter / Quotation -->
    <h2 class="qa-heading reveal">OFFER LETTER / QUOTATION</h2>

    <div class="qa-body reveal" style="--d:.08s">

      <div class="to-line">
        To,
        <span></span>
        <span></span>
        <span></span>
      </div>

      <p class="subject">
        Subject: - <u>Architectural / Interior Quotation &amp; Schedule for consultancy and design services</u>
      </p>

      <p class="greet">Respected Sir,</p>

      <p>
        With reference to our discussions about the projects at ......................................., we are submitting the best quotation for architectural / Interior services to be provided accordingly.
      </p>

      <p>The particulars &amp; the rates are as under :-</p>

      <table class="qa-table">
        <thead>
          <tr>
            <th>Particulars</th>
            <th>Rate</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Fees on Total Construction Cost (drawings + supervision)</td><td>4 % (Flat)</td></tr>
          <tr><td>Fees on Total Construction Cost (drawings only)</td><td>2 % (Flat)</td></tr>
          <tr><td>Submission Drawings ( Onetime payment )</td><td>Rs. 8000.00 ( lumsum)</td></tr>
          <tr><td>Graphical Visualisation ( 3D View) ( Onetime payment )</td><td>Rs. 8000.00 ( lumsum)</td></tr>
          <tr><td>Structural Fees ( drawings + supervision )</td><td>0.5 % (Flat)</td></tr>
          <tr><td>Interiors Designing Fees ( drawings + supervision )</td><td>8 % (Flat)</td></tr>
          <tr><td>Landscaping Designing Fees ( drawings + supervision )</td><td>6 % (Flat)</td></tr>
          <tr><td>For Renovation- Designing Fees ( drawings + supervision )</td><td>8 % (Flat)</td></tr>
        </tbody>
      </table>

      <p class="qa-thanks">Thanking you and assuring you the best of our services.</p>

      <div class="qa-signs">
        <div class="qa-sign">(OWNER / CLIENT SIGN)</div>
        <div class="qa-sign">M. B. DESIGN &amp; BUILD</div>
      </div>

    </div>

    <!-- Services Banner -->
    <div class="qa-banner reveal">
      <img src="assets/img/quotation/services-banner.png" alt="Our Services" onerror="this.parentElement.style.background='linear-gradient(135deg,var(--ink),var(--gold-d))';this.parentElement.style.height='120px';">
    </div>

    <!-- Letterhead 2 -->
    <div class="qa-letterhead reveal">
      <img src="assets/img/quotation/letterhead-top.png" alt="MB Design & Build Letterhead" onerror="this.parentElement.style.background='linear-gradient(135deg,var(--gold-d),var(--ink))';this.parentElement.style.height='160px';">
    </div>

    <!-- Date -->
    <div class="qa-date reveal">Date : &nbsp;&nbsp; / &nbsp;&nbsp; / 20&nbsp;&nbsp;&nbsp;&nbsp;</div>

    <!-- Agreement -->
    <h2 class="qa-heading reveal">Agreement</h2>

    <div class="qa-agreement reveal" style="--d:.08s">

      <h3>Agreement</h3>
      <h4>Execution Of Residential / Commercial Project Work.</h4>

      <p class="intro">
        This Work order Agreement for Civil / Interior / Furnished Residential or Commercial Project Executed on 01/01/2020 at, NAGPUR (MAHARASHTRA, INDIA)
      </p>

      <div class="between">BETWEEN</div>

      <div class="party">
        <b>M. B. DESIGN &amp; BUILD</b><br>
        <span class="role">Planners – Architects – Interior Designers</span><br>
        Office : Block No. 21, Tulsi Apartment, Telephone Exchange Square, C.A. Road, NAGPUR - 08.<br>
        41, Amrapali Nagar, Nr. Sai Nagar-2 Bus Stop, Hudkeshwar Road, NAGPUR - 34.
      </div>

      <div class="between">AND</div>

      <div class="party">
        <b>.......................................................</b><br>
        <span class="role">(Client / Owner Name)</span><br>
        Address : .......................................................<br>
        .......................................................
      </div>

      <p style="margin-top:30px; line-height:1.8;">
        Whereas the Client has approached M. B. Design &amp; Build for architectural, interior and construction consultancy services for their proposed Residential / Commercial project, and both parties have mutually agreed to the terms and conditions mentioned hereunder:
      </p>

      <h4 style="text-align:left; margin-top:30px;">Terms &amp; Conditions</h4>

      <ol style="line-height:2; padding-left:22px;">
        <li>All designs, drawings and plans shall remain the intellectual property of M. B. Design &amp; Build until full payment is received.</li>
        <li>Payment shall be made in instalments as per the agreed schedule.</li>
        <li>Any modification in the approved design after execution shall be charged additionally.</li>
        <li>The client shall provide all necessary approvals, permissions and site access in a timely manner.</li>
        <li>M. B. Design &amp; Build shall not be held liable for delays caused due to factors beyond their control.</li>
        <li>This agreement shall be governed by the laws of India and subject to the jurisdiction of Nagpur courts.</li>
      </ol>

      <div class="qa-signs" style="margin-top:60px;">
        <div class="qa-sign">(OWNER / CLIENT SIGN)</div>
        <div class="qa-sign">M. B. DESIGN &amp; BUILD</div>
      </div>

    </div>

    <!-- Print Button -->
    <div style="text-align:center;">
      <button class="qa-print" onclick="window.print()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Print / Download PDF
      </button>
    </div>

  </div>
</section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>