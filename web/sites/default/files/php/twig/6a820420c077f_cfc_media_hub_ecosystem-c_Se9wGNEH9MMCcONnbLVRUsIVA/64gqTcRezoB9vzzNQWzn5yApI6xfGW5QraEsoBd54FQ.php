<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:ecosystem-cta */
class __TwigTemplate_086b69baf974947074f7b72b426a8a45 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--ecosystem-cta"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:ecosystem-cta"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:ecosystem-cta"));
        yield "<section class=\"bg-[#FCFCFB] py-20 border-t border-b border-[#9F5434]/10 relative\" x-data=\"{ open: false }\">
  <div class=\"max-w-[1440px] mx-auto px-12 grid grid-cols-12 gap-16 items-center\">
    <div class=\"col-span-6\">
      <div class=\"flex items-center gap-3 mb-4\">
        <div class=\"w-5 h-[2px] bg-[#9F5434]\"></div>
        <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#9F5434] font-semibold\">Ecosystems</div>
      </div>
      <h2 class=\"text-neutral-900 tracking-tight mb-6\" style=\"font-size: 52px; font-weight: 600; line-height: 1.05; letter-spacing: -0.025em;\">
        Connecting you to Africa\x27s business ecosystem
      </h2>
      <p class=\"text-neutral-600 leading-relaxed max-w-[520px] text-[18px]\">
        CFC Media Hub connects international journalists with Africa\x27s business, institutional and media ecosystem.
      </p>
    </div>
    <div class=\"col-span-6 flex items-center justify-end\">
      <div class=\"flex flex-col items-end gap-6 max-w-[380px] w-full\">
        <p class=\"text-neutral-500 text-right leading-relaxed text-[14px]\">
          Submit a connection request and our team will coordinate introductions with CFC member companies, institutions and organisations on your behalf.
        </p>
        <button type=\"button\" x-on:click=\"open = true\" class=\"inline-flex items-center gap-2 bg-[#9F5434] hover:bg-[#8A4A2E] text-white px-8 py-4 rounded-full group transition-colors shadow-[0_8px_20px_-8px_rgba(159,84,52,0.4)]\">
          <span class=\"font-semibold text-[14px]\">Submit a Connection Request</span>
          ";
        // line 22
        yield from $this->load("cfc_media_hub:icon", 22)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4", "class" => "group-hover:translate-x-0.5 transition-transform"]));
        // line 23
        yield "        </button>
      </div>
    </div>
  </div>

  ";
        // line 28
        yield from $this->load("cfc_media_hub:connection-request-modal", 28)->unwrap()->yield([]);
        // line 29
        yield "</section>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:ecosystem-cta";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  81 => 29,  79 => 28,  72 => 23,  70 => 22,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:ecosystem-cta", "themes/custom/cfc_media_hub/components/ecosystem-cta/ecosystem-cta.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 22];
        static $filters = [];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "include"],
                [],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
