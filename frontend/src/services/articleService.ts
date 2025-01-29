import api from "./api";

export const getArticles = async (filters: { keyword: string, category: string, source: string, date: string }) => {
  try {
    const response = await api.get("/articles", { params: filters });
    return response;
  } catch (error) {
    console.error("Error fetching articles", error);
    throw error;
  }
};

export const getPersonalizedFeed = async (page: number = 1) => {
  return api.get(`/personalized-feed?page=${page}`);
};
