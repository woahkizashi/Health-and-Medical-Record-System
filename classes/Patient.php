<?php
class Patient {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all patients
    public function getPatients() {
        $this->db->query('SELECT * FROM patients ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get patient by ID
    public function getPatientById($id) {
        $this->db->query('SELECT * FROM patients WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Add patient
    public function addPatient($data) {
        $this->db->query('INSERT INTO patients (user_id, name, dob, gender, address, phone, blood_type, allergies, medical_history) VALUES (:user_id, :name, :dob, :gender, :address, :phone, :blood_type, :allergies, :medical_history)');
        
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':dob', $data['dob']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':blood_type', $data['blood_type']);
        $this->db->bind(':allergies', $data['allergies']);
        $this->db->bind(':medical_history', $data['medical_history']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Update patient
    public function updatePatient($data) {
        $this->db->query('UPDATE patients SET name = :name, dob = :dob, gender = :gender, address = :address, phone = :phone, blood_type = :blood_type, allergies = :allergies, medical_history = :medical_history WHERE id = :id');
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':dob', $data['dob']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':blood_type', $data['blood_type']);
        $this->db->bind(':allergies', $data['allergies']);
        $this->db->bind(':medical_history', $data['medical_history']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Delete patient
    public function deletePatient($id) {
        $this->db->query('DELETE FROM patients WHERE id = :id');
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>