import React, { useEffect, useState } from "react";
import { getArticles } from "../services/articleService";
import { Toast } from "react-bootstrap";

const placeholderImage = "../assets/placeholder.png";

const Home: React.FC = () => {
  const [articles, setArticles] = useState([]);
  const [searchTerm, setSearchTerm] = useState("");
  const [category, setCategory] = useState("");
  const [source, setSource] = useState("");
  const [date, setDate] = useState("");
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
    const filters = {
      keyword: searchTerm,
      category,
      source,
      date: date,
      page,
    };

    try {
      const response = await getArticles(filters);
      setArticles((prevArticles) =>
        reset
          ? response.data.data.data
          : [...prevArticles, ...response.data.data.data]
      );
      setCurrentPage(response.data.data.current_page);
      setLastPage(response.data.data.last_page);
    } catch (error) {
      setError("Error fetching articles");
      setShowErrorToast(true);
    } finally {
      setLoading(false);
    }
  };

  const handleFilterChange = () => {
    setCurrentPage(1);
    fetchArticles(1, true);
  };

  return (
    <div className="container mt-5">
      <h2 className="mb-4">Articles</h2>

      {/* Filter Section */}
      <div className="row mb-4">
        <div className="col-md-3">
          <input
            type="text"
            className="form-control"
            placeholder="Search by keyword"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            onBlur={handleFilterChange}
          />
        </div>
        <div className="col-md-3">
          <input
            type="text"
            className="form-control"
            placeholder="Category"
            value={category}
            onChange={(e) => setCategory(e.target.value)}
            onBlur={handleFilterChange}
          />
        </div>
        <div className="col-md-3">
          <input
            type="text"
            className="form-control"
            placeholder="Source"
            value={source}
            onChange={(e) => setSource(e.target.value)}
            onBlur={handleFilterChange}
          />
        </div>
        <div className="col-md-3">
          <input
            type="date"
            className="form-control"
            value={date}
            onChange={(e) => setDate(e.target.value)}
            onBlur={handleFilterChange}
          />
        </div>
      </div>

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
          No articles found.
        </div>
      )}

      {/* Articles List */}
      <div className="row">
        {articles.map((article: any) => (
          <div key={article.id} className="col-md-3 mb-4">
            <div className="card shadow-sm" style={{ fontSize: "0.9rem" }}>
              <img
                src={article.image_url && article.image_url.trim() !== "" ? article.image_url : placeholderImage}
                alt={article.title}
                className="card-img-top"
                style={{ height: "150px", objectFit: "cover" }}
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

export default Home;
