import React, { useState, useEffect } from "react";
import { useAuth } from "../context/AuthContext";
import { Container, Form, Button, Card, Spinner, Alert } from "react-bootstrap";

const UserPreferences: React.FC = () => {
  const { preferences, updateUserPreferences } = useAuth();
  const [formPreferences, setFormPreferences] = useState({
    sources: [],
    categories: [],
    authors: [],
  });
  const [loading, setLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);
  const [success, setSuccess] = useState<string>("");

  useEffect(() => {
    if (preferences?.data) {
      setFormPreferences({
        sources: preferences?.data?.sources || [],
        categories: preferences?.data?.categories || [],
        authors: preferences?.data?.authors || [],
      });
    }
  }, [preferences]);

  // console.log(preferences?.data, "preferences...");

  const handleChange = (key: string, value: string) => {
    setFormPreferences((prev) => ({
      ...prev,
      [key]: value.split(",").map((item) => item.trim()),
    }));
  };

  const handleUpdatePreferences = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setErrorMessage(null);

    try {
      await updateUserPreferences(formPreferences);
      setSuccess("Preference updated successfully.");
    } catch (error: any) {
      console.error("Failed to update preferences", error);
      setErrorMessage(
        error.response?.data?.message ||
          "An unexpected error occurred. Please try again."
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <Container
      className="d-flex justify-content-center align-items-center"
      style={{ minHeight: "100vh" }}
    >
      <Card className="p-4 shadow-lg w-100" style={{ maxWidth: "600px" }}>
        <Card.Body>
          <h2 className="text-center mb-4">User Preferences</h2>

          {errorMessage && <Alert variant="danger">{errorMessage}</Alert>}
          {success && <Alert variant="success">{success}</Alert>}

          <Form onSubmit={handleUpdatePreferences}>
            {/* Sources Input */}
            <Form.Group controlId="formSources">
              <Form.Label>News Sources (comma-separated)</Form.Label>
              <Form.Control
                type="text"
                value={formPreferences.sources.join(", ")}
                onChange={(e) => handleChange("sources", e.target.value)}
                placeholder="Enter sources"
              />
            </Form.Group>

            {/* Categories Input */}
            <Form.Group controlId="formCategories">
              <Form.Label>Categories (comma-separated)</Form.Label>
              <Form.Control
                type="text"
                value={formPreferences.categories.join(", ")}
                onChange={(e) => handleChange("categories", e.target.value)}
                placeholder="Enter categories"
              />
            </Form.Group>

            {/* Authors Input */}
            <Form.Group controlId="formAuthors">
              <Form.Label>Preferred Authors (comma-separated)</Form.Label>
              <Form.Control
                type="text"
                value={formPreferences.authors.join(", ")}
                onChange={(e) => handleChange("authors", e.target.value)}
                placeholder="Enter preferred authors"
                
              />
            </Form.Group>

            <Button
              variant="primary"
              type="submit"
              className="w-100 mt-3"
              disabled={loading}
            >
              {loading ? (
                <Spinner
                  as="span"
                  animation="border"
                  size="sm"
                  role="status"
                  aria-hidden="true"
                />
              ) : (
                "Update Preferences"
              )}
            </Button>
          </Form>
        </Card.Body>
      </Card>
    </Container>
  );
};

export default UserPreferences;
