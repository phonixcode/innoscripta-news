import React, { useEffect, useState } from "react";
import { useAuth } from "../context/AuthContext";
import { getPersonalizedFeed } from "../services/articleService";
import { Toast } from "react-bootstrap";

const placeholderImage = "../assets/placeholder.png";

const PersonalizedFeed: React.FC = () => {
  const { user } = useAuth();
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [showErrorToast, setShowErrorToast] = useState(false);
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);

  useEffect(() => {
    fetchArticles(1, true);
  }, []);

  const fetchArticles = async (page = 1, reset = false) => {
    setLoading(true);
    try {
      const response = await getPersonalizedFeed(page);
      setArticles((prevArticles) =>
        reset
          ? response.data.data.data
          : [...prevArticles, ...response.data.data.data]
      );
      setCurrentPage(response.data.data.current_page);
      setLastPage(response.data.data.last_page);
    } catch (error) {
      setError("Error fetching personalized articles");
      setShowErrorToast(true);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="container mt-5">
      <h2 className="mb-4">Personalized Articles for {user?.data?.name}</h2>

      {/* Loading Animation */}
      {loading && (
        <div className="d-flex justify-content-center mb-4">
          <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      )}

      {/* Error Toast */}
      {showErrorToast && (
        <Toast
          onClose={() => setShowErrorToast(false)}
          show={showErrorToast}
          delay={3000}
          autohide
          bg="danger"
          className="position-absolute top-0 end-0 m-3"
        >
          <Toast.Body>{error}</Toast.Body>
        </Toast>
      )}

      {/* No Articles Found Message */}
      {articles.length === 0 && !loading && (
        <div className="alert alert-warning" role="alert">
          No personalized articles found.
        </div>
      )}

      {/* Articles List */}
      <div className="row">
        {articles.map((article: any) => (
          <div key={article.id} className="col-md-3 mb-4">
            <div className="card shadow-sm" style={{ fontSize: "0.9rem" }}>
              <img
                src={
                  article.image_url && article.image_url.trim() !== ""
                    ? article.image_url
                    : placeholderImage
                }
                alt={article.title}
                className="card-img-top"
                style={{ height: "150px", objectFit: "cover" }}
                onError={(e) => (e.currentTarget.src = placeholderImage)}
              />

              <div className="card-body">
                <h5 className="card-title" style={{ fontSize: "1rem" }}>
                  {article.title}
                </h5>
                <p className="card-text" style={{ fontSize: "0.85rem" }}>
                  {article.description}
                </p>
                <p className="card-text" style={{ fontSize: "0.85rem" }}>
                  <strong>Category:</strong> {article.category}
                </p>
                <p className="card-text" style={{ fontSize: "0.85rem" }}>
                  <strong>Source:</strong> {article.source}
                </p>
                <p className="card-text" style={{ fontSize: "0.75rem" }}>
                  <small className="text-muted">
                    Published on{" "}
                    {new Date(article.published_at).toLocaleDateString()}
                  </small>
                </p>
                <a
                  href={article.url}
                  className="btn btn-primary btn-sm"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  Read More
                </a>
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Load More Button */}
      {currentPage < lastPage && (
        <div className="text-center mt-4">
          <button
            className="btn btn-primary"
            onClick={() => fetchArticles(currentPage + 1)}
          >
            Load More
          </button>
        </div>
      )}
    </div>
  );
};

export default PersonalizedFeed;
