import React, { useState, useEffect } from "react";
import { useAuth } from "../context/AuthContext";
import { Container, Form, Button, Card, Spinner, Alert } from "react-bootstrap";

const UserProfile: React.FC = () => {
  const { user, updateUserProfile } = useAuth();
  const [name, setName] = useState("");
  const [password, setPassword] = useState("");
  const [passwordConfirmation, setPasswordConfirmation] = useState("");
  const [error, setError] = useState<string>("");
  const [success, setSuccess] = useState<string>("");
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (user?.data?.name) {
      setName(user.data.name);
    }
  }, [user]);

  const handleUpdateProfile = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    const updateData: any = { name };
    if (password) {
      updateData.password = password;
      updateData.password_confirmation = passwordConfirmation;
    }

    try {
      await updateUserProfile(updateData);
      setSuccess("Profile updated successfully.");
      setPassword("");
      setPasswordConfirmation("");
    } catch (err: any) {
      console.error("Update Profile Error:", err.response?.data);

      if (err.response?.data?.errors) {
        const errorMessages = Object.values(err.response.data.errors).flat().join(" ");
        setError(errorMessages);
      } else if (err.response?.data?.message) {
        setError(err.response.data.message);
      } else {
        setError("An unexpected error occurred. Please try again.");
      }
    } finally {
      setLoading(false);
    }
  };

  if (!user) {
    return <p>Loading profile...</p>;
  }

  return (
    <Container className="d-flex justify-content-center align-items-center" style={{ minHeight: "100vh" }}>
      <Card className="p-4 shadow-lg" style={{ width: "100%", maxWidth: "500px" }}>
        <Card.Body>
          <h2 className="text-center mb-4">User Profile</h2>
          {error && <Alert variant="danger">{error}</Alert>}
          {success && <Alert variant="success">{success}</Alert>}
          <Form onSubmit={handleUpdateProfile}>
            <Form.Group controlId="formName">
              <Form.Label>Name</Form.Label>
              <Form.Control
                type="text"
                placeholder="Enter your name"
                value={name}
                onChange={(e) => setName(e.target.value)}
                required
              />
            </Form.Group>

            <Form.Group controlId="formEmail" className="mt-3">
              <Form.Label>Email</Form.Label>
              <Form.Control type="email" value={user.data?.email} disabled />
            </Form.Group>

            <Form.Group controlId="formPassword" className="mt-3">
              <Form.Label>New Password (Optional)</Form.Label>
              <Form.Control
                type="password"
                placeholder="Enter your new password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </Form.Group>

            <Form.Group controlId="formPasswordConfirmation" className="mt-3">
              <Form.Label>Confirm Password</Form.Label>
              <Form.Control
                type="password"
                placeholder="Confirm your new password"
                value={passwordConfirmation}
                onChange={(e) => setPasswordConfirmation(e.target.value)}
              />
            </Form.Group>

            <Button variant="primary" type="submit" className="w-100 mt-4" disabled={loading}>
              {loading ? (
                <>
                  <Spinner as="span" animation="border" size="sm" role="status" aria-hidden="true" className="me-2" />
                  Updating...
                </>
              ) : (
                "Update Profile"
              )}
            </Button>
          </Form>
        </Card.Body>
      </Card>
    </Container>
  );
};

export default UserProfile;
