<template>
  <div class="contact-page">
    <h3>Contact Us</h3>
    <form @submit.prevent="handleSubmit">
        <div class="field-holder">
            <input type="text" class="form-control" id="name" required>
            <label for="name">Name</label>
            <div class="valid-feedback">
                Please enter your name.
            </div>
        </div>

        <div class="field-holder">
            <input type="email" class="form-control" id="email" required>
            <label for="email">Email</label>
            <div class="valid-feedback">
                Please enter a valid email adress.
            </div>
        </div>

        <div class="field-holder">
            <textarea id="message" v-model="formData.message" class="form-control" rows="5" required></textarea>
            <label for="message">Message</label>
            <div class="valid-feedback">
            </div>
        </div>
        
    <button class="btn btn-primary" type="submit">Send Message</button>
    </form>
  </div>
</template>

<script>
import emailjs from 'emailjs-com';

export default {
  name: 'ContactPage',
  data() {
    return {
      formData: {
        name: '',
        email: '',
        message: '',
      },
    };
  },
  methods: {
    async sendEmail() {
    if (!this.formData.name || !this.formData.email || !this.formData.message) {
        alert("Please fill out all fields.");
        return;
    }

    try {
        await emailjs.send(
        "YOUR_SERVICE_ID", // Replace with your EmailJS Service ID
        "YOUR_TEMPLATE_ID", // Replace with your EmailJS Template ID
        {
            from_name: this.formData.name,
            from_email: this.formData.email,
            message: this.formData.message,
        },
        "YOUR_USER_ID" // Replace with your EmailJS User ID
        );

        alert("Message sent successfully!");
        this.formData = { name: "", email: "", message: "" }; // Reset form
    } catch (error) {
        console.error("Error sending email:", error);
        alert("Failed to send message. Please try again.");
    }
    },
  },

};
</script>

<style scoped>
.contact-page {
    max-width: 600px;
    margin: 2rem auto;
    padding: 1rem;
}

h3{
    margin-bottom: 4rem;
}

.field-holder {
  position: relative;
  margin-bottom: 1.5rem;
}

input:focus, input:active {
    outline: none;
    border-bottom: solid 1px #47663B;
    box-shadow: none !important;
}

textarea:focus, textarea:active {
    outline: none;
    border-bottom: solid 1px #47663B;
    box-shadow: none !important;
}

input, textarea {
    border: none;
    border-bottom: 1px solid #000;
    outline: none;
    border-radius: 0;
    color: #000;
    font-size: 1rem;
}

textarea {
    resize: none;
}

label {
  position: absolute;
  top: 0; 
  left: 10px;
  font-size: 1rem;
  font-weight: 500;
  color: #000; 
  text-transform: uppercase;
  transition: all 0.3s ease;
  pointer-events: none;
  display: flex;
  align-items: center;
  cursor: text;
}

input, textarea, label {
    width: 100%;
    font-size: 1rem;
    font-family: 'Inter', sans-serif;
}

input:focus + label, input:valid + label {
  top: -1.5rem;
  font-size: 0.8rem;
  pointer-events: none;
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover,
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
  -webkit-box-shadow: 0 0 0px 1000px #ffffff inset !important;
}

textarea:focus + label, textarea:valid + label {
  top: -1.5rem;
  font-size: 0.8rem;
  pointer-events: none;
}

.btn {
    display: block;
    font-size: 1rem;
    color: #fff;
    background-color: #000;
    border: none;
    cursor: pointer;
    border-radius: 0 !important;
    font-family: 'Inter', sans-serif;
}

.btn:focus, .btn:active {
    outline: none;
    background-color: #47663B;
    box-shadow: none;
}

.btn {
  --bs-btn-active-bg: #47663B;
}

.btn:hover {
  background-color: #47663B;
}
</style>
