export type Meta = {
  current_page: number;
  from: number;
  last_page: number;
  links: Link[];
  path: string;
  per_page: 10;
  to: number;
  total: number;
};

type Link = {
  url: string;
  label: string;
  active: boolean;
};
